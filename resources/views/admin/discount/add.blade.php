@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <a href="{{ route('admin.discount.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="discountForm" id="discountForm" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="base_discount">{{ __('Base Discount') }}<span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="base_discount" id="base_discount" class="form-control" placeholder="Base Discount" onkeypress="return decimalsonly(this, event)"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="incremental_discount">{{ __('Incremental Discount') }}<span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="incremental_discount" id="incremental_discount" class="form-control" placeholder="Incremental Discount" onkeypress="return decimalsonly(this, event)"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="max_discount">{{ __('Max Discount') }}<span class="text-danger">*</span><span class="error"></span></label>
                                    <input type="text" name="max_discount" id="max_discount" class="form-control" placeholder="Max Discount" onkeypress="return decimalsonly(this, event)"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="products">Products</label>
                                    <ul style="list-style: none; padding-left: 2.5rem;">
                                    @foreach($products as $product)
                                        <li style="padding-bottom: 0.35rem;"><input type="checkbox" name="products[]" value="{{ $product->id }}" /> {{ $product->title }} &nbsp; &nbsp;</li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                                <div class="form-group">
                                    @csrf
                                    <button type="submit" name="discountInsert" id="discountInsert" class="btn btn-default">
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
