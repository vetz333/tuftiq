<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function add()
    {
        $categories = ProductCategory::latest()->get();
        return view('backend.product.add_product', compact('categories'));
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'price' => 'required',
        //     'tags' => 'required',
        //     'description' => 'required',
        //     'product_image' => 'required',
        // ],
        // [
        //     'name' => 'Input Category Name',
        // ]);
        $image = $request->file('product_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(900,900)->save('upload/product/main/'.$name_gen);
        $save_url = 'upload/product/main/'.$name_gen;

        $product_id = Product::insertGetId([
            'categories_id' => $request->categories_id,
            'name' => $request->name,
            'price' => $request->price,
            'tags' => $request->tags,
            'description' => $request->description,
            'product_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $images = $request->file('product_gallery');
        foreach ($images as $img) {
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(900,900)->save('upload/product/second/'.$make_name);
            $uploadPath = 'upload/product/second/'.$make_name;

            ProductGallery::insert([

                'products_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),

            ]);
        }

        $notification = array(
            'message' => 'Product added successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('manage.product')->with($notification);
    }

    public function manage()
    {
        $products = Product::latest()->get();

        return view('backend.product.manage_product', compact('products'));
    }

    public function edit($id)
    {
        $productGalleries = ProductGallery::where('products_id',$id)->get();
        $categories = ProductCategory::latest()->get();
        $products =Product::findOrFail($id);

        return view('backend.product.product_edit', compact('categories', 'products', 'productGalleries'));
    }

    public function update(Request $request)
    {
        $product_id = $request->id;

        Product::findOrFail($product_id)->update([
            'categories_id' => $request->categories_id,
            'name' => $request->name,
            'price' => $request->price,
            'tags' => $request->tags,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Product updated successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('manage.product')->with($notification);
    }

    public function updateGallery(Request $request)
    {
        $images = $request->product_gallery;

        foreach ($images as $id => $image) {

            $imgDel = ProductGallery::findOrFail($id);
            unlink($imgDel->photo_name);
            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(900,900)->save('upload/product/second/'.$make_name);
            $uploadPath = 'upload/product/second/'.$make_name;

            ProductGallery::where('id',$id)->update([
                'photo_name'=> $uploadPath,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Product image updated successfully',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);

        }
    }

    public function updateImage(Request $request)
    {
        $products_id = $request->id;
        $oldImage = $request->old_image;

        unlink($oldImage);
        $image = $request->file('product_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(900,900)->save('upload/product/main/'.$name_gen);
        $save_url = 'upload/product/main/'.$name_gen;

        Product::findOrFail($products_id)->update([
            'product_image' => $save_url,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product image updated successfully',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);


    }

    public function deleteGallery($id)
    {
        $oldGallery = ProductGallery::findOrFail($id);
        unlink($oldGallery->photo_name);
        ProductGallery::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product image deleted successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->product_image);
        Product::findOrFail($id)->delete();

        $galleries = ProductGallery::where('products_id',$id)->get();
        foreach ($galleries as $gallery) {
            unlink($gallery->photo_name);
            ProductGallery::where('products_id',$id)->delete();
        }
        $notification = array(
            'message' => 'Product deleted successfully',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }


}

