@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.subadmin.index') }}">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="searchKey" name="searchKey" placeholder="Search Keyword" value="{{ app('request')->input('searchKey') }}" mandatory />
                    </div>
                    <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.subadmin.index') }}'">Reset</button>
                    <a href="{{ route('admin.subadmin.create') }}" class="btn btn-default btn-sm pull-right">Add</a>
                </form>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@sortablelink('name','Name')</th>
                                <th>@sortablelink('email','Email')</th>
                                <th>@sortablelink('role','Role')</th>
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->role->title }}</td>
                                <td class="action">
                                    <a href="{{route('admin.subadmin.edit', $data->id)}}" class="text-info" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success': 'text-warning' }}" data-id="{{ $data->id }}" data-alias="Admin" data-toggle="tooltip" data-placement="bottom" title="Status">
                                        <i class="fa fa-{{ $data->status?'check':'times' }}-circle"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="resetPassword-{{ $data->id }}" class="resetPassword text-info" data-id="{{ $data->id }}" data-alias="Admin" data-toggle="tooltip" data-placement="bottom" title="Reset Password">
                                        <i class="fa fa-key"></i>
                                    </a>
                                    {{--
                                    <a href="javascript:void(0)" class="deleteData text-danger" data-id="{{ $data->id }}" data-alias="Admin" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    --}}
                                </td>
                            </tr>
                            @empty
                                <tr><td colspan="4" class="text-center"><strong>No data found.</strong></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div id="paginationSection">{{ $all_data->appends(request()->except('page'))->links() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="resetPasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <div class="modal-body">
                <form class="form" name="resetPasswordForm" id="resetPasswordForm" method="post" enctype="multipart/form-data">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="newPassword">New Password <span class="text-danger">*</span><span class="error"></span></label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control" onkeypress="return restrictSpace(event);" />
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password <span class="text-danger">*</span><span class="error"></span></label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" onkeypress="return restrictSpace(event);" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                        <div class="form-group">
                            @csrf
                            <input type="hidden" id="id" name="id" value="">
                            <button type="button" name="resetPasswordUpdate" id="resetPasswordUpdate" class="btn btn-default">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection