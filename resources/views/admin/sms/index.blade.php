@extends('admin.master')

@section('admin_content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SMS List</h1>
                </div>
            </div><!-- /.row -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('sms.inputform') }}" class="btn btn-primary">
                        + Add SMS
                    </a>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">SMS Title</th>
                                <th scope="col">Text</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $row)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $row->sms_title }}</td>
                                <td>{{ $row->text }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-{{ $row->status ? 'success' : 'danger' }}">
                                        {{ $row->status ? 'Enable' : 'Disable' }}
                                    </button>
                                </td>
                                <td>
                                    {{-- <button type="button" class="btn btn-info btn-sm edit" data-id="{{ $row->id }}" data-toggle="modal" data-target="#editModal">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button> --}}
                                    <a href="{{ route('sms.edit', $row->id) }}" class="btn btn-info btn-sm edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="{{ route('sms.delete', $row->id) }}" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
