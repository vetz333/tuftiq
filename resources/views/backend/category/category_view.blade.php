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
     <h3 class="box-title">Category List</h3>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
       <div class="table-responsive">
         <table id="example1" class="table table-bordered table-striped">
           <thead>
               <tr>
                   <th>Category Name</th>
                   <th>Image</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>
            @foreach ($categories as $item)
               <tr>
                   <td>{{$item->name}}</td>
                   <td><img src="{{asset($item->image)}}" alt="" style="width: 80px; height: 80px;"></td>
                    <td><a href="{{route('category.edit', $item->id)}}" class="btn btn-info">Edit</a>
                    <a href="{{route('category.delete', $item->id)}}" class="btn btn-danger" id="delete">Delete</a>
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
