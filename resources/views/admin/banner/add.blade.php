@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <a href="{{ route('admin.banner.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="bannerForm" id="bannerForm" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="title" id="title" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group" style="margin-bottom: 0px;">
                                    <label>Banner Type</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label class="fancy-radio">
                                        <input name="bannerType" value="image" type="radio" checked /> <span><i></i>Image</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label class="fancy-radio">
                                        <input name="bannerType" value="video" type="radio" /> <span><i></i>Video</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="imageRow" class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="thumb">Mobile <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="file" name="thumb" id="thumb" class="form-control" accept="image/*" />
                                    <span class="sizeOption">(Image Size: 1366 X 600px)</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="image">Desktop <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                                    <span class="sizeOption">(Image Size: 1366 X 400px)</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="redirect_url">Redirect URL<span class="error"></span></label>
                                    <input type="text" name="redirect_url" id="redirect_url" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="redirect_target">Redirect Target</label>
                                    <select name="redirect_target" id="redirect_target" class="form-control">
                                        <option value="">Redirect Target</option>
                                        <option value="_self">Same Tab</option>
                                        <option value="_blank">New Tab</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="videoRow" class="row" style="display:none;">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="poster">Poster <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="file" name="poster" id="poster" class="form-control" accept="image/*" />
                                    <span class="sizeOption">(Image Size: 1366 X 400px)</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="video">Video <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="file" name="video" id="video" class="form-control" accept=".mp4" />
                                </div>
                            </div>
                            {{--
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="video">Video Code <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="video" id="video" class="form-control" />
                                </div>
                            </div>
                            --}}
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12 text-center mt20px">
                            <div class="form-group">
                                @csrf
                                <button type="submit" name="bannerInsert" id="bannerInsert" class="btn btn-default">
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
