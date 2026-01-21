@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <a href="{{ route('admin.order.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="orderForm" id="orderForm" method="post" enctype="multipart/form-data">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $data->name }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="orderid">Order ID</label>
                                <input type="text" name="orderid" id="orderid" class="form-control" value="{{$data->id}}" readonly />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="order_status">Order Status <span class="text-danger">*</span><span class="error"></span></label>
                                <select class="form-control" id="order_status" name="order_status">
                                    <option value="">Order Status</option>
                                    <option value="New" disabled {{ ($data->order_status=='New')?'selected':'' }}>New</option>
                                    <option value="Packed" {{ ($data->order_status=='Packed')?'selected':'' }}>Order Packed</option>
                                    <option value="Shipped" {{ ($data->order_status=='Shipped')?'selected':'' }}>Order Shipped</option>
                                    <option value="Delivered" {{ ($data->order_status=='Delivered')?'selected':'' }}>Order Delivered</option>
                                    <option value="Cancelled" disabled {{ ($data->order_status=='Cancelled')?'selected':'' }}>Order Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" id="remark" class="form-control">{{$data->remark}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="docket_link">Docket Link</label>
                                <input type="text" name="docket_link" id="docket_link" class="form-control" value="{{ $data->docket_link }}" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="docket_number">Docket Number</label>
                                <input type="text" name="docket_number" id="docket_number" class="form-control" value="{{ $data->docket_number }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                            <div class="form-group">
                                @method('PUT') @csrf
                                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                <button type="submit" name="orderUpdate" id="orderUpdate" class="btn btn-default">
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
