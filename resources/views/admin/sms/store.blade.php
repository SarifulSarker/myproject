@extends('admin.master')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add SMS</h1>
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->

    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('sms.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlInput1">SMS Title</label>
                                <input type="text" class="form-control" name="sms_title">
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Text</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Status</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
