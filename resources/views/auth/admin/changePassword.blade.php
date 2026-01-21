@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form"></div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="changePasswordForm" id="changePasswordForm" method="post" enctype="multipart/form-data">
                        <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
                            <div class="form-group">
                                <label for="oldPassword">Old Password <span class="text-danger">*</span><span class="error"></span></label>
                                <input type="password" name="oldPassword" id="oldPassword" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
                            <div class="form-group">
                                <label for="newPassword">New Password <span class="text-danger">*</span><span class="error"></span></label>
                                <input type="password" name="newPassword" id="newPassword" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password <span class="text-danger">*</span><span class="error"></span></label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                            <div class="form-group">
                                @csrf
                                <button type="submit" name="changePasswordUpdate" id="changePasswordUpdate" class="btn btn-default">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection