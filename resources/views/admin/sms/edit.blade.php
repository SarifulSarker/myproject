@extends('admin.master')

@section('admin_content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit SMS</h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('sms.update', $data->id) }}" method="POST">
                            @csrf


                            <div class="form-group">
                                <label for="sms_title">SMS Title</label>
                                <input type="text" class="form-control" id="sms_title" name="sms_title" value="{{ $data->sms_title }}">
                            </div>

                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea class="form-control" id="text" rows="3" name="text">{{ $data->text }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Enable</option>
                                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Disable</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
