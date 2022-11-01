@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->

		<!-- Main content -->
		<section class="content">

		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Edit Product</h4>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">
					<form method="POST" action="{{route('product.update')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $products->id }}">


					  <div class="row">
						<div class="col-12">
							<div class="form-group">
								<h5>Category Select <span class="text-danger">*</span></h5>
								<div class="controls">
                                    <select name="categories_id" class="form-control" required>
                                        <option value="" selected disabled >Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == $products->categories_id ? 'selected' : '' }} >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
                            <div class="form-group">
								<h5>Product Name <span class="text-danger">*</span></h5>
								<div class="controls">
                                   <input type="text" name="name" class="form-control" required value="{{ $products->name }}">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
                            <div class="form-group">
								<h5>Product Tags <span class="text-danger">*</span></h5>
								<div class="controls">
                                   <input type="text" name="tags" class="form-control" data-role="tagsinput" required value="{{ $products->tags }}">
                                    @error('tags')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
                            <div class="form-group">
								<h5>Product Price <span class="text-danger">*</span></h5>
								<div class="controls">
                                   <input type="text" name="price" class="form-control" required value="{{ $products->price }}">
                                    @error('price')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>




							<div class="form-group">
								<h5>Product Description <span class="text-danger">*</span></h5>
								<div class="controls">
									<textarea name="description" id="editor1" rows="10" cols="80">
                                        {!! $products->description !!}
                                    </textarea>
								</div>
							</div>
						</div>
					  </div>
						<div class="text-xs-right">
							<input type="submit" class="btn btn-rounded btn-info mb-5" value="Update Product"></input>
						</div>
					</form>

				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /.box -->

		</section>
		<!-- /.content -->

        <section class="content">
            <div class="row">

            <div class="col-md-12">
                <div class="box bt-3 border-info">
                    <div class="box-header">
                        <h4 class="box-title">
                            Product Gallery Update
                        </h4>
                    </div>

            <form action="{{route('update.product.image')}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="row row-sm">
                @foreach ($productGalleries as $gallery )
                    <div class="col-md-3">
                        <div class="card">
                        <img src="{{ asset($gallery->photo_name) }}" class="card-img-top" style="height: 280px; width: 280px;" />
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{route('product.gallery.delete', $gallery->id)}}" class="btn btn-sm btn-danger" id="delete" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </h5>
                            <p class="card-text">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Change Image <span class="tx-danger">*</span></label>
                                    <input type="file" class="form-control" name="product_gallery[{{$gallery->id}}]">
                                </div>

                            </p>
                        </div>
                    </div>

                    </div><!-- end col-md-3 -->
                @endforeach

                </div>
                <div class="text-xs-right">
							<input type="submit" class="btn btn-rounded btn-info mb-5" value="Update Image"></input>
			    </div>
                <br><br>

            </form>
                </div>
            </div>

            </div><!-- end row image -->
        </section> <!-- end section image -->

        <section class="content">
            <div class="row">

            <div class="col-md-12">
                <div class="box bt-3 border-info">
                    <div class="box-header">
                        <h4 class="box-title">
                            Product Main Image Update
                        </h4>
                    </div>

            <form action="{{route('update.product.main.image')}}" method="POST" enctype="multipart/form-data" >
                @csrf

                <input type="hidden" name="id" value="{{ $products->id }}">
                <input type="hidden" name="old_image" value="{{ $products->product_image }}">
                <div class="row row-sm">
                    <div class="col-md-3">
                        <div class="card">
                        <img src="{{ asset($products->product_image) }}" class="card-img-top" style="height: 280px; width: 280px;" />
                        <div class="card-body">

                            <p class="card-text">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Change Image <span class="tx-danger">*</span></label>
									<input type="file" name="product_image" class="form-control" onchange="productImg(this)" >
                                    <img src="" id="productImage">
                                </div>
                            </p>
                        </div>
                    </div>

                    </div><!-- end col-md-3 -->

                </div>
                <div class="text-xs-right">
							<input type="submit" class="btn btn-rounded btn-info mb-5" value="Update Image"></input>
			    </div>
                <br><br>

            </form>

                </div>
            </div>

            </div><!-- end row image -->
        </section> <!-- end section image -->


	  </div><!-- end container-full -->
  </div><!-- end content wrapper -->


<script type="text/javascript">
    function productImg(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#productImage').attr('src', e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#productGallery').on('change',function(){
        if(window.File && window.FileReader && window.FileList && window.Blob){
            var data =$(this)[0].files;

            $.each(data,function(index,file){
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
                    var fRead = new FileReader();
                    fRead.onload = (function(file){
                        return function(e){
                            var img = $('<img/>').addClass('thumb').attr('src',e.target.result).width(100).height(100);
                            $('#preview_img').append(img);
                        };
                    })(file);
                    fRead.readAsDataURL(file);
                }
            });
        }else{
            alert("Your browser doesn't support file API!");
        }
    })
})

</script>


@endsection
