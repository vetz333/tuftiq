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
			  <h4 class="box-title">Add Product</h4>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">
					<form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
                        @csrf
					  <div class="row">
						<div class="col-12">
							<div class="form-group">
								<h5>Category Select <span class="text-danger">*</span></h5>
								<div class="controls">
                                    <select name="categories_id" class="form-control" required>
                                        <option value="" selected disabled >Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
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
                                   <input type="text" name="name" class="form-control" required>
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
                            <div class="form-group">
								<h5>Product Tags <span class="text-danger">*</span></h5>
								<div class="controls">
                                   <input type="text" name="tags" class="form-control" value="Lorem,Ipsum,Amet" data-role="tagsinput" required>
                                    @error('tags')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
                            <div class="form-group">
								<h5>Product Price <span class="text-danger">*</span></h5>
								<div class="controls">
                                   <input type="text" name="price" class="form-control" required>
                                    @error('price')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
								</div>
							</div>
							<div class="form-group">
								<h5>Product Image <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="file" name="product_image" class="form-control" onchange="productImg(this)" required>
                                    @error('product_image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    <img src="" id="productImage">
                                </div>
							</div>
                            <div class="form-group">
								<h5>Product Gallery <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="file" name="product_gallery[]" class="form-control" multiple id="productGallery" required>
                                    @error('product_gallery')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                  <div class="row" id="preview_img"></div>
                                </div>
							</div>
							<div class="form-group">
								<h5>Product Description <span class="text-danger">*</span></h5>
								<div class="controls">
									<textarea name="description" id="editor1" rows="10" cols="80"></textarea>
								</div>
							</div>
						</div>
					  </div>
						<div class="text-xs-right">
							<input type="submit" class="btn btn-rounded btn-info mb-5" value="Add Product"></input>
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
	  </div>
  </div>


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
