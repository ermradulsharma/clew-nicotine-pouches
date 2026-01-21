@extends('layouts.admin')

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
                    <h3 class="panel-title">{{$product->title}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form" name="productSimilarForm" id="productSimilarForm" method="post" enctype="multipart/form-data">
                        <div class="row pt20px">
                            <div class="col-sm-12 col-md-12 col-xs-12 logoListWrap">
                                @foreach($products as $similar)
                                <div id="similarDiv-{{$similar->id}}" class="similars @if(in_array($similar->id,$productSimilars)) border-selected @else border-default @endif" data-id="{{$similar->id}}" title="{{$similar->title}}">
                                    <input type="checkbox" id="similar-{{$similar->id}}" name="similars[]" value="{{$similar->id}}" style="display:none;" @if(in_array($similar->id,$productSimilars)) checked @endif />
                                    
                                    @php
                                        $productImage = $similar->variants()->where('status', 1)->orderBy('position', 'asc')->first();            
                                    @endphp
                                    @if($productImage)
                                    @php $thumb =  asset('storage/product/thumb/'.$productImage->thumb); @endphp
                                    @else
                                    @php $thumb = asset('images/product-thumb.png'); @endphp
                                    @endif
                                    <img src="{{$thumb}}" style="width:100px;"/><br/>
                                    <span>{{$similar->title}}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row pt20px">
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                                <div class="form-group">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{$product->id}}" />
                                    <button type="submit" name="productSimilarInsert" id="productSimilarInsert" class="btn btn-default">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Product Similar</th>
                                {{--<th class="w120px">Position</th>--}}
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->product->title }}</td>
                                @php $productData = \App\Models\Product::find($data->similar_id); @endphp
                                <td>{{ $productData->title }}</td>
                                {{--
                                <td>
									<form id="positionForm" name="positionForm" action="{{ route('admin.product.similar.position') }}" method="post">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="position" value="{{ $data->position }}" onkeypress="return numbersonly(event)" maxlength="3" />
                                            <input type="hidden" name="id" value="{{ $data->id }}" />
                                            <input type="hidden" name="product_id" value="{{ $data->product_id }}" />
                                            <input type="hidden" name="similar_id" value="{{ $data->similar_id }}" />
                                            @csrf
                                            <span class="input-group-btn"><button type="submit" class="btn btn-default btn-sm">Go</button></span>
                                        </div>
                                    </form>
                                </td>
                                --}}
                                <td class="action">
                                    <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success':'text-warning' }}" data-id="{{ $data->id }}" data-alias="ProductSimilar" data-toggle="tooltip" data-placement="bottom" title="Status">
                                        <i class="fa fa-{{ $data->status?'check':'times' }}-circle"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="deleteData text-danger" data-id="{{ $data->id }}" data-alias="ProductSimilar" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr><td colspan="6" class="text-center"><strong>No data found.</strong></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
