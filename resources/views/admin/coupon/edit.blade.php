@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <a href="{{ route('admin.coupon.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="couponForm" id="couponForm" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ $data->title }}" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="code">Code <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="code" id="code" class="form-control" value="{{ base64_decode($data->code) }}" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="discount_type">Discount Type <span class="text-danger">*</span><span class="error"></span></label>
                                    <select class="form-control" name="discount_type" id="discount_type">
                                    <option value="">Select</option>
                                        <option value="percentage" @if($data->discount_type=='percentage') selected @endif>Percentage %</option>
                                        <option value="flat" @if($data->discount_type=='flat') selected @endif>Flat discount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="discount">Discount(%) <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="discount" id="discount" class="form-control" value="{{ $data->discount }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="units">Units <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="units" id="units" class="form-control" maxlength="5" onkeypress="return numbersonly(event)" value="{{ $data->units }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="products">Products</label>
                                    @foreach($products as $product)
                                    @php $checked = ($data->products)?((in_array($product->id, json_decode($data->products)))?'checked':''):''
                                    @endphp
                                    <input type="checkbox" name="products[]" value="{{ $product->id }}" {{ $checked }} /> {{ $product->title }} &nbsp; &nbsp;
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="start_date">Start Date <span class="text-danger">*</span><span class="error"></span></label>
                                    <div class="input-group">
                                        <input type="text" name="start_date" id="start_date" class="form-control" value="{{ $data->start_date }}" readonly="" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="end_date">End Date <span class="text-danger">*</span><span class="error"></span></label>
                                    <div class="input-group">
                                        <input type="text" name="end_date" id="end_date" class="form-control" value="{{ $data->end_date }}" readonly="" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                                <div class="form-group">
                                    @method("PUT") @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                    <button type="submit" name="couponUpdate" id="couponUpdate" class="btn btn-default">
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
