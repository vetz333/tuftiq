@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->

		<!-- Main content -->
		<section class="content">
		  <div class="row">

          <div class="col-12">

<div class="box">
   <div class="box-header with-border">
     <h3 class="box-title">Edit Category</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
       <div class="table-responsive">
       <form method="POST" action="{{route('category.update', $category->id)}}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{$category->id}}">
            <input type="hidden" name="old_image" value="{{$category->image}}">

                <div class="form-group">
                       <h5>Category Name <span class="text-danger">*</span></h5>
                       <div class="controls">
                           <input type="text" name="name" class="form-control" value="{{ $category->name }}" >
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                   </div>
                   <div class="form-group">
                       <h5>Category Image <span class="text-danger">*</span></h5>
                       <div class="controls">
                           <input type="file" name="image" class="form-control">
                           @error('image')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                   </div>

               <div class="text-xs-right">
                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Update">
               </div>
           </form>
       </div>
   </div>
   <!-- /.box-body -->
 </div>
 <!-- /.box -->

</div>
			<!-- /.col -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->

	  </div>
  </div>







@endsection
