@extends('layouts.admin')
@push('after-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <a href="{{ route('admin.product.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="productForm" id="productForm" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span><span class="error"></span></label>
                                    <select id="category_id" name="category_id" class="form-control">
                                        <option value="">Category</option>
                                        @foreach($categories as $category)
                                        @php $selected = ($data->category_id==$category->id)?'selected':''; @endphp
                                        <option value="{{ $category->id }}" {{ $selected }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="title" id="title" value="{{ $data->title }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="flavour_id">Flavor <span class="text-danger">*</span><span class="error"></span></label>
                                    <select class="form-control" id="flavour_id" name="flavour_id">
                                        <option value="">Flavor</option>
                                        @foreach($flavours as $flavour)
                                        @php $selected = ($data->flavour_id==$flavour->id)?'selected':''; @endphp
                                        <option value="{{ $flavour->id }}" {{ $selected }}>{{ $flavour->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="sku_code">SKU Code <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="sku_code" id="sku_code" value="{{ $data->sku_code }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="label_id">Label</label>
                                    <select class="form-control" id="label_id" name="label_id">
                                        <option value="">Label</option>
                                        @foreach($labels as $label)
                                        @php $selected = ($data->label_id==$label->id)?'selected':''; @endphp
                                        <option value="{{ $label->id }}" {{ $selected }}>{{ $label->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{--
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="tagline">Tagline</label>
                                    <input type="text" name="tagline" id="tagline" value="{{ $data->tagline }}" class="form-control" />
                                </div>
                            </div>
                            --}}
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="price">Price <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="price" id="price" value="{{ $data->price }}" class="form-control" onkeypress="return decimalsonly(this, event);" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="rating">Rating</label>
                                    <select class="form-control" id="rating" name="rating">
                                        <option value="">Rating</option>
                                        @for($rating = 1; $rating<=5; $rating++)
                                        @php $selected = ($data->rating==$rating)?'selected':''; @endphp
                                        <option value="{{ $rating }}" {{ $selected }}>{{ $rating }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="banner">Banner <span class="error"></span></label>
                                    <div class="input-group">
                                        <input type="file" name="banner" id="banner" class="form-control" accept="image/*" />
                                        <span class="input-group-addon" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="<img src='{{ asset('storage/product/banner/'.$data->banner) }}' class='img-150w' />">
                                            <img src="{{ asset('storage/product/banner/'.$data->banner) }}" style="width: 24px; height: 20px;" />
                                        </span>
                                    </div>
                                    <span class="sizeOption">(Banner Size: 1080px X 422px)</span>
                                </div>
                            </div>
                        </div>
                        {{---
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="mrp">MRP <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="mrp" id="mrp" value="{{ $data->mrp }}" class="form-control" onkeypress=" return decimalsonly(this, event);" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="price">Price <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="price" id="price" value="{{ $data->price }}" class="form-control" onkeypress=" return decimalsonly(this, event);" />
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="strengths">Strengths</label>
                                    @foreach($strengths as $strength)
                                    <input type="checkbox" name="strengths[]" value="{{ $strength->id }}" {{ in_array($strength->id, $data->selected_strengths ?? []) ? 'checked' : '' }} /> {{ $strength->title }} &nbsp; &nbsp;
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="base_discount">Base Discount <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="base_discount" id="base_discount" value="{{ $data->base_discount }}" class="form-control" onkeypress=" return decimalsonly(event);" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="incremental_discount">Incremental Discount <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="incremental_discount" id="incremental_discount" value="{{ $data->incremental_discount }}" class="form-control" onkeypress=" return decimalsonly(event);" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="max_discount">Max Discount <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="max_discount" id="max_discount" value="{{ $data->max_discount }}" class="form-control" onkeypress=" return decimalsonly(event);" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="restricted_state">Restricted State</label>
                                    <select class="form-control" id="restricted_state" name="restricted_state[]" multiple>
                                        <option value="">Restricted State</option>
                                        @php
                                            $selectedStates = explode(',', $data->restricted_state ?? '');
                                        @endphp
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}" {{ in_array($state->id, $selectedStates) ? 'selected' : '' }}>
                                                {{ $state->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{--
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control">{{ $data->short_description }}</textarea>
                                    <script type="text/javascript">CKEDITOR.replace('short_description');</script>
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control">{{ $data->description }}</textarea>
                                    <script type="text/javascript">CKEDITOR.replace('description');</script>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pageTitle">Page Title</label>
                                    <textarea class="form-control" name="pageTitle" id="pageTitle">{{ $data->pageTitle }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pageDescription">Page Description</label>
                                    <textarea class="form-control" name="pageDescription" id="pageDescription">{{ $data->pageDescription }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pageKeywords">Page Keywords</label>
                                    <textarea class="form-control" name="pageKeywords" id="pageKeywords">{{ $data->pageKeywords }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                                <div class="form-group">
                                    @method('PUT') @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                    <button type="button" name="productUpdate" id="productUpdate" class="btn btn-default">
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
@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#restricted_state').select2({
                placeholder: "Select restricted state(s)",
                allowClear: true
            });
        });
    </script>
@endpush