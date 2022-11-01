<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductCategoryController extends Controller
{
    public function view()
    {
        $categories = ProductCategory::latest()->get();
        return view('backend.category.category_view', compact('categories'));
    }

    public function add()
    {
        $categories = ProductCategory::latest()->get();
        return view('backend.category.add_category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ],
        [
            'name' => 'Input Category Name',
        ]);
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        ProductCategory::insert([
            'name' => $request->name,
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Category created successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }

    public function edit($id)
    {
        $category =ProductCategory::findOrFail($id);

        return view('backend.category.category_edit', compact('category'));
    }

    public function update(Request $request)
    {
        $category_id =$request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

        unlink($old_img);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        ProductCategory::findOrFail($category_id)->update([
            'name' => $request->name,
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Category updated successfully',
            'alert-type' => 'info',
        );

        return redirect()->route('all.category')->with($notification);

        }else {

            ProductCategory::findOrFail($category_id)->update([
                'name' => $request->name,
            ]);

            $notification = array(
                'message' => 'Category updated successfully',
                'alert-type' => 'info',
            );

            return redirect()->route('all.category')->with($notification);

        }

    }

    public function delete($id)
    {
        $category = ProductCategory::findOrFail($id);
        $img = $category->image;
        unlink($img);
        ProductCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category deleted successfully',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }
}
