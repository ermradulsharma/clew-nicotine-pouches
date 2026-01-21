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
                                    <input type="text" name="title" id="title" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="code">Code <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="code" id="code" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="discount_type">Discount Type <span class="text-danger">*</span><span class="error"></span></label>
                                    <select class="form-control" name="discount_type" id="discount_type">
                                    <option value="">Select</option>
                                        <option value="percentage">Percentage %</option>
                                        <option value="flat">Flat discount</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="discount">Discount <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="discount" id="discount" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="units">Units <span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="units" id="units" class="form-control" maxlength="5" onkeypress="return numbersonly(event)" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="products">Products</label>
                                    @foreach($products as $product)
                                    <input type="checkbox" name="products[]" value="{{ $product->id }}" /> {{ $product->title }} &nbsp; &nbsp;
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="start_date">Start Date <span class="text-danger">*</span><span class="error"></span></label>
                                    <div class="input-group">
                                        <input type="text" name="start_date" id="start_date" class="form-control" readonly="" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="end_date">End Date <span class="text-danger">*</span><span class="error"></span></label>
                                    <div class="input-group">
                                        <input type="text" name="end_date" id="end_date" class="form-control" readonly="" />
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                                <div class="form-group">
                                    @csrf
                                    <button type="submit" name="couponInsert" id="couponInsert" class="btn btn-default">
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
