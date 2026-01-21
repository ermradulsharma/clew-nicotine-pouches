@extends('layouts.admin')



@section('content')

@include('layouts.parts.admin.header')

@include('layouts.parts.admin.sidebar')

<div class="main">

    <!-- MAIN CONTENT -->

    <div class="main-content">

        <div class="container-fluid">

            <div class="search-form">

                <a href="{{ route('admin.website.index') }}" class="btn btn-default btn-sm pull-right">Back</a>

            </div>

            <!-- OVERVIEW -->

            <div class="panel panel-headline">

                <div class="panel-heading">

                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>

                </div>

                <div class="panel-body">

                    <form class="form" name="websiteForm" id="websiteForm" method="post" enctype="multipart/form-data">

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>

                                <input type="text" name="title" id="title" value="{{ $data->title }}" class="form-control" />

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <div class="form-group">

                                <label for="logo">Logo <span class="text-danger">*</span><span class="error"></span></label>

                                <div class="input-group">

                                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*" />

                                    <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/website/'.$data->logo) }}' class='img-150w' />">

                                        <img src="{{ asset('storage/website/'.$data->logo) }}" style="width: 24px; height: 20px;" />

                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <div class="form-group">

                                <label for="favicon">Favicon <span class="text-danger">*</span><span class="error"></span></label>

                                <div class="input-group">

                                    <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*" />

                                    <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/website/'.$data->favicon) }}' class='img-150w' />">

                                        <img src="{{ asset('storage/website/'.$data->favicon) }}" style="width: 24px; height: 20px;" />

                                    </span>

                                </div>

                            </div>

                        </div>

                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="disclaimer">Disclaimer</label>
                                <textarea class="form-control" name="disclaimer" id="disclaimer">{{ $data->disclaimer }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <label for="pageTitle">Page Title</label>

                                <textarea name="pageTitle" id="pageTitle" class="form-control">{{ $data->pageTitle }}</textarea>

                            </div>

                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <label for="pageDescription">Page Description</label>

                                <textarea class="form-control" name="pageDescription" id="pageDescription">{{ $data->pageDescription }}</textarea>

                            </div>

                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <label for="pageKeywords">Page Keywords</label>

                                <textarea class="form-control" name="pageKeywords" id="pageKeywords">{{ $data->pageKeywords }}</textarea>

                            </div>

                        </div>                        

                        <div class="col-sm-12 col-md-12 col-xs-12 text-center">

                            <div class="form-group">

                                @method('PUT') @csrf

                                <input type="hidden" id="id" name="id" value="{{ $data->id }}">

                                <button type="button" name="websiteUpdate" id="websiteUpdate" class="btn btn-default">

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

