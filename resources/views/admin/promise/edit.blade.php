@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <a href="{{ route('admin.promise.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="promiseForm" id="promiseForm" method="post" enctype="multipart/form-data">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $data->title }}" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="image">Image <span class="error"></span></label>
                                    <div class="input-group">
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                                        <input type="hidden" name="imageOld" id="imageOld" value="{{ $data->image }}" />
                                        <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/promise/'.$data->image) }}' class='img-150w' />">
                                            <img src="{{ asset('storage/promise/'.$data->image) }}" style="width: 24px; height: 20px;" />
                                        </span>
                                    </div>
                                    <span class="sizeOption">(Image Size: 575px X 250px)</span>
                                </div>
                            </div>
                        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                            <div class="form-group">
                                @method('PUT') @csrf
                                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                <button type="submit" name="promiseUpdate" id="promiseUpdate" class="btn btn-default">
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
