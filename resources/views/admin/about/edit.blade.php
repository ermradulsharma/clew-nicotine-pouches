@extends('layouts.admin')

@section('content')
    @include('layouts.parts.admin.header')
    @include('layouts.parts.admin.sidebar')

    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <div class="search-form">
                    <a href="{{ route('admin.about.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
                </div>
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form" name="aboutForm" id="aboutForm" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                        <input type="text" name="title" id="title" value="{{ $data->title }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="image">Image <span class="text-danger">*</span><span class="error"></span></label>
                                        <div class="input-group">
                                            <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                                            <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/about/'.$data->image) }}' class='img-150w' />">
                                                <img src="{{ asset('storage/about/'.$data->image) }}" style="width: 24px; height: 20px;" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="description">Description <span class="text-danger">*</span><span class="error"></span></label>
                                        <textarea class="form-control" name="description" id="description">{{ $data->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12"><h4>Our Mission</h4><div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="om_title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                        <input type="text" name="om_title" id="om_title" value="{{ $data->om_title }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="om_image">Image <span class="text-danger">*</span><span class="error"></span></label>
                                        <div class="input-group">
                                            <input type="file" name="om_image" id="om_image" class="form-control" accept="image/*" />
                                            <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/about/'.$data->om_image) }}' class='img-150w' />">
                                                <img src="{{ asset('storage/about/'.$data->om_image) }}" style="width: 24px; height: 20px;" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="om_description">Description <span class="text-danger">*</span><span class="error"></span></label>
                                        <textarea class="form-control" name="om_description" id="om_description">{{ $data->om_description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12"><h4>Our Values</h4><div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="ov_title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                        <input type="text" name="ov_title" id="ov_title" value="{{ $data->ov_title }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="ov_image">Image <span class="text-danger">*</span><span class="error"></span></label>
                                        <div class="input-group">
                                            <input type="file" name="ov_image" id="ov_image" class="form-control" accept="image/*" />
                                            <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/about/'.$data->ov_image) }}' class='img-150w' />">
                                                <img src="{{ asset('storage/about/'.$data->ov_image) }}" style="width: 24px; height: 20px;" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="ov_description">Description <span class="text-danger">*</span><span class="error"></span></label>
                                        <textarea class="form-control" name="ov_description" id="ov_description">{{ $data->ov_description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12"><h4>Quality Assurance</h4><div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="qa_title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                        <input type="text" name="qa_title" id="qa_title" value="{{ $data->qa_title }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="qa_image">Image <span class="text-danger">*</span><span class="error"></span></label>
                                        <div class="input-group">
                                            <input type="file" name="qa_image" id="qa_image" class="form-control" accept="image/*" />
                                            <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/about/'.$data->qa_image) }}' class='img-150w' />">
                                                <img src="{{ asset('storage/about/'.$data->qa_image) }}" style="width: 24px; height: 20px;" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="qa_description">Description <span class="text-danger">*</span><span class="error"></span></label>
                                        <textarea class="form-control" name="qa_description" id="qa_description">{{ $data->qa_description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12"><h4>Nevcore Innovations</h4><div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="ni_title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                        <input type="text" name="ni_title" id="ni_title" value="{{ $data->ni_title }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="ni_image">Image <span class="text-danger">*</span><span class="error"></span></label>
                                        <div class="input-group">
                                            <input type="file" name="ni_image" id="ni_image" class="form-control" accept="image/*" />
                                            <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/about/'.$data->ni_image) }}' class='img-150w' />">
                                                <img src="{{ asset('storage/about/'.$data->ni_image) }}" style="width: 24px; height: 20px;" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="ni_description">Description <span class="text-danger">*</span><span class="error"></span></label>
                                        <textarea class="form-control" name="ni_description" id="ni_description">{{ $data->ni_description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12"><h4>Manufacturing</h4><div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="m_title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                        <input type="text" name="m_title" id="m_title" value="{{ $data->m_title }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="m_image">Image <span class="text-danger">*</span><span class="error"></span></label>
                                        <div class="input-group">
                                            <input type="file" name="m_image" id="m_image" class="form-control" accept="image/*" />
                                            <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/about/'.$data->m_image) }}' class='img-150w' />">
                                                <img src="{{ asset('storage/about/'.$data->m_image) }}" style="width: 24px; height: 20px;" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="m_video">Video <span class="text-danger">*</span><span class="error"></span></label>
                                        <input type="text" name="m_video" id="m_video" value="{{ $data->m_video }}" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="m_description">Description <span class="text-danger">*</span><span class="error"></span></label>
                                        <textarea class="form-control" name="m_description" id="m_description">{{ $data->m_description }}</textarea>
                                    </div>
                                </div>
                            </div>                      
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                                    <div class="form-group">
                                        @method('PUT') @csrf
                                        <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                        <button type="button" name="aboutUpdate" id="aboutUpdate" class="btn btn-default">
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

