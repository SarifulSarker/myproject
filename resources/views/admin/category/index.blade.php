@extends('admin.master')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal"> + Add Category</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>



    <table class="table table-bordered text-center" >
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Category Name</th>
            <th scope="col">Category Slug</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
    @foreach ($data as $key=>$row )
    <tr>
        <th scope="row">{{$key++}}</th>
        <td>{{$row->category_name}}</td>
        <td>{{$row->category_slug}}</td>
        <td>
            <button type="button" value="{{$row->id}}" href="#" class="btn btn-info btn-sm edit" data-id ="{{$row->id}}" data-toggle="modal" data-target="#editModal"><i class="fa-solid fa-pen-to-square"></i></button>
            <a href="{{route('category.delete', $row->id)}} " id="delete" class="btn btn-danger btn-sm" id="delete"><i class="fa-solid fa-trash"></i></a>
        </td>
      </tr>

    @endforeach

        </tbody>
      </table>


   {{-- category insert model --}}
   <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add new Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('category.store')}}" method="POST">
            @csrf
        <div class="modal-body">

                <div class="mb-3">
                  <label for="category_name" class="form-label">Category Name</label>
                  <input type="text" class="form-control" id="category_name" name="category_name" required="">
                  <div id="emailHelp" class="form-text">This is your main category</div>
                </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  {{--category edit model--}}
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('category.update')}}" method="POST">
            @csrf
        <div class="modal-body">

                <div class="mb-3">
                  <label for="category_name" class="form-label">Category Name</label>
                  <input type="text" class="form-control" id="e_category_name" name="category_name" required="">
         <input type="hidden" class="form-control" id="e_category_id" name="id">
                  <div id="emailHelp" class="form-text">This is your main category</div>
                </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script type="text/javascript">
	$('body').on('click','.edit', function(){
		let cat_id=$(this).data('id');
		$.get('/category/edit/'+cat_id, function(data){
           $('#e_category_name').val(data.category_name);
           $('#e_category_id').val(data.id);
           //console.log(data);
		});
       // alert(cat_id);
	});


</script>



 <script>
    $(document).on("click", '#delete', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure you want to Delete ?',
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            } else {
                Swal.fire("Safe Data");
            }
        });
    });
</script>


 @endsection



