
@extends('admin.master')

@section('admin_content')


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Brand</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ul>
                <ol class="breadcrumb float-sm-left">

                   <a href="{{ route('brand-index-pdf') }}"  class="btn btn-xs btn-info pull-right">export pdf</a>
                  </ol>
                <ol class="breadcrumb float-sm-right">
                  <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"> + Add New</button>
                </ol>
            </ul>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Brand List Here</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                  <table id="" class="table table-bordered table-striped table-sm ytable">
                    <thead>
                    <tr>
                      <th>SL</th>
                      <th>Brand Name</th>
                      <th>Brand Slug</th>
                      <th>Brand Logo</th>
                      <th>Home Page</th>
                      <th>Action</th>
                      <th width="50px"><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">Delete</button></th>
                    </tr>
                    </thead>
                    <tbody>


                    </tbody>
                  </table>
                </div>
	          </div>
	      </div>
	  </div>
	</div>
</section>
</div>

{{-- brand insert modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form action="{{ route('brand.store') }}" method="Post" enctype="multipart/form-data" id="add-form">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="brand-name">Brand Name</label>
            <input type="text" class="form-control"  name="brand_name" required="">
            <small id="emailHelp" class="form-text text-muted">This is your Brand </small>
          </div>
           <div class="form-group">
            <label for="brand-name">Brand Logo</label>
            <input type="file" class="dropify" data-height="140" id="input-file-now" name="brand_logo" required="">
            <small id="emailHelp" class="form-text text-muted">This is your Brand Logo </small>
          </div>
          <div class="form-group">
            <label for="brand-name">Home Pgae Show</label>
            <select class="form-control" name="front_page">
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
            <small id="emailHelp" class="form-text text-muted">If yes it will be show on your home page </small>
          </div>
      </div>
      <div class="modal-footer">
        <button type="Submit" class="btn btn-primary"> <span class="d-none"> loading..... </span>  Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{--- edit modal---}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       <div id="modal_body">

       </div>
      </div>
    </div>
  </div>


  {{-- for multiple delete option --}}

  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <form method="post" id="sample_form" class="form-horizontal">
    <div class="modal-header">
    <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <h4  style="margin:0; text-align:center">Are you sure you want to remove this data?</h4>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
    </div>
    </form>
    </div>
    </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>

<script type="text/javascript">
	$('.dropify').dropify();

</script>
<script type="text/javascript">
	$(function brand(){
		var table=$('.ytable').DataTable({
			processing:true,
			serverSide:true,
			ajax:"{{ route('brand.index') }}",
			columns:[
				{data:'DT_RowIndex',name:'DT_RowIndex'},
				{data:'brand_name'  ,name:'brand_name'},
				{data:'brand_slug',name:'brand_slug'},
				{data:'brand_logo',name:'brand_logo', render: function(data, type ,full,meta){

                return '<img src="/' + data + '" width="50" height="30">';


				}

            },

                      {data:'front_page',name:'front_page'},
				{data:'action',name:'action',orderable:true, searchable:true},
                {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},

			]
		});




    $('body').on('click','.edit', function(){
    let id=$(this).data('id');
    $.get("/brand/edit/"+id, function(data){
         $("#modal_body").html(data);
    });
  });


  //for multiple delete

  var user_id;

  $(document).on('click', '.delete', function(){
      user_id = $(this).attr('id');
      $('#confirmModal').modal('show');
  });


  $(document).on('click', '#bulk_delete', function(){
      var id = [];
      if(confirm("Are you sure you want to Delete this data?"))
      {
          $('.users_checkbox:checked').each(function(){
              id.push($(this).val());
          });
          if(id.length > 0)
          {
              $.ajax({
                  url:"{{ route('brand.removeall')}}",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  method:"get",
                  data:{id:id},
                  success:function(data)
                  {
                      console.log(data);
                      alert(data);
                      window.location.assign("index");
                  },
                  error: function(data) {
                      var errors = data.responseJSON;
                      console.log(errors);
                  }
              });
          }
          else
          {
              alert("Please select atleast one checkbox");
          }
      }
  });

       });





</script>


@endsection
