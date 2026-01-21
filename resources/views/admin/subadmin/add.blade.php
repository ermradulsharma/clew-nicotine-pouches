@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <a href="{{ route('admin.subadmin.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="subadminForm" id="subadminForm" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="name" id="name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="email" id="email" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="role_id">Role <span class="text-danger">*</span><span class="error"></span></label>
                                    <select class="form-control" id="role_id" name="role_id">
                                        <option value="" selected disabled>Role</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="password" name="password" id="password" class="form-control" onkeypress="return restrictSpace(event);" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" onkeypress="return restrictSpace(event);" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center mt20px">
                                <div class="form-group">
                                    @csrf
                                    <button type="submit" name="subadminInsert" id="subadminInsert" class="btn btn-default">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection