@extends('admin.master')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">student</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#studentModal"> +student</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>



    <table class="table table-striped">
        <thead>
            <tr>

                <th scope="col">SL</th>
                <th scope="col">Name</th>
                <th scope="col">Class</th>
                <th scope="col">Roll</th>
                <th scope="col">ID</th>
                <th scope="col">Session</th>
                <th scope="col">Phone</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $row)

            <tr>

                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $row->name }}</td>
                <td>{{ $row->class }}</td>
                <td>{{ $row->roll }}</td>
                <td>{{ $row->student_id }}</td>
                <td>{{ $row->session }}</td>
                <td>{{ $row->phone }}</td>
                <td>

                    
                    <img src="{{ asset($row->image) }}" width= '50' height='50' class="img img-responsive" />
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>


   {{-- category insert model --}}
   <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add new student</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('student.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">

                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" required="">

                </div>
                <div class="mb-3">
                    <label for="roll" class="form-label">Roll</label>
                    <input type="text" class="form-control" id="roll" name="roll" required="">

                  </div>
                  <div class="mb-3">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" required="">

                  </div>
                  <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <input type="text" class="form-control" id="class" name="class" required="">

                  </div>
                  <div class="mb-3">
                    <label for="session" class="form-label">Session</label>
                    <input type="text" class="form-control" id="session" name="session" required="">

                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required="">

                  </div>
                  <div class="mb-3">
                    <label for="image" class="form-label">image</label>
                    <input class="form-control" name="image" type="file" id="image">

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




 @endsection



