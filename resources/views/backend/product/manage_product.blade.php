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
     <h3 class="box-title">Product List</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
       <div class="table-responsive">
         <table id="example1" class="table table-bordered table-striped">
           <thead>
               <tr>
                   <th>Product Name</th>
                   <th>Price</th>
                   <th>Tags</th>
                   <th>Description</th>
                   <th>Image</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>
            @foreach ($products as $item)
               <tr>
                   <td>{{$item->name}}</td>
                   <td>{{$item->price}}</td>
                   <td>{{$item->tags}}</td>
                   <td>{!!$item->description!!}</td>
                   <td><img src="{{asset($item->product_image)}}" alt="" style="width: 80px; height: 80px;"></td>
                    <td><a href="{{route('product.edit', $item->id)}}" class="btn btn-info">Edit</a>
                    <a href="{{route('product.delete', $item->id)}}" class="btn btn-danger" id="delete">Delete</a>
                    </td>
                </tr>
            @endforeach
           </tbody>
         </table>
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
