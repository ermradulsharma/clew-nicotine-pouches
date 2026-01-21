@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                {{--
                <form id="productImageForm" name="productImageForm" class="form-inline">
                    <div class="form-group">
                        <input type="text" name="title" id="title" class="form-control input-sm" placeholder="Title" value="{{$product->title}}" />
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" id="image" class="form-control input-sm" accept="image/*" />
                        <span class="sizeOption">(Image Size: 1000px X 670px)</span>
                    </div>
                    <input type="hidden" name="product_id" id="product_id" class="form-control input-sm" value="{{$product->id}}" />
                    <button type="submit" id="productImageInsert" class="btn btn-default btn-sm">Save</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{route('admin.product.images.index', $product->id)}}'">Reset</button>
                </form>
                --}}
                <a href="{{ route('admin.product.index') }}" class="btn btn-default btn-sm pull-right">Back</a>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}
                        <a href="javascript:void(0)" class="btn btn-default btn-sm pull-right productImageAdd" product_id="{{$product->id}}">Add</a>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@sortablelink('title','Title')</th>
                                <td>Strength</td>
                                <th>Image</th>
                                <th class="w120px">@sortablelink('position','Position')</th>
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->strength->title }}</td>
                                <td>
                                    @if($data->image)
                                        @php $imgSrc = asset('storage/product/multishots/thumb/'.$data->image); @endphp
                                    @else
                                        @php $imgSrc = asset('admin/img/no-image.png') @endphp
                                    @endif
                                    <img id="editImg-{{$data->id}}" src="{{$imgSrc}}" class="img-100w" data-id="{{$data->id}}" data-alias="ProductImage" />
                                </td>
                                <td>
                                    <div class="input-group">
										<input class="form-control" type="text" id="position-{{$data->id}}" value="{{ $data->position }}" onkeypress="return numbersonly(event)" maxlength="3">
										<span class="input-group-btn"><button class="btn btn-default btn-sm positionData" data-id="{{$data->id}}" data-alias="ProductImage" type="button">Go</button></span>
									</div>
                                </td>
                                <td class="action">
                                    <a href="javascript:void(0)" class="text-info productImageEdit" data-id="{{ $data->id }}" data-product_id="{{ $data->product_id }}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {{--
                                    <a href="javascript:void(0)" id="preferredData-{{ $data->id }}" class="preferredData text-warning" data-id="{{ $data->id }}" data-alias="ProductImage" data-toggle="tooltip" data-placement="bottom" title="Preferred">
                                        <i class="glyphicon glyphicon-{{$data->preferred?'star':'star-empty'}}"></i>
                                    </a>
                                    --}}
                                    <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success': 'text-warning' }}" data-id="{{ $data->id }}" data-alias="ProductImage" data-toggle="tooltip" data-placement="bottom" title="Status">
                                        <i class="fa fa-{{ $data->status?'check':'times' }}-circle"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="deleteData text-danger" data-id="{{ $data->id }}" data-alias="ProductImage" data-toggle="tooltip" data-placement="bottom" title="Delete">
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
                <div id="paginationSection">{{ $all_data->appends(request()->except('page'))->links() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="productImageAddModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="title" class="modal-title">{{ $product->title }}</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div id="productImageEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="title" class="modal-title">{{ $product->title }}</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
@endsection
