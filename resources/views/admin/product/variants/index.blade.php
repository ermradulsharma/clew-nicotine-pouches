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
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}
                        <a href="javascript:void(0)" class="btn btn-default btn-sm pull-right productVariantAdd" product_id="{{$product->id}}">Add</a>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@sortablelink('strength_id','Strength')</th>
                                <th>@sortablelink('price','Price')</th>
                                <th>Image</th>
                                <th class="w120px">@sortablelink('position','Position')</th>
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->strength->title }}</td>
                                <td>{{ $data->price }}</td>
                                <td>
                                    @if($data->image)
                                        @php $imgSrc = asset('storage/product/thumb/'.$data->image); @endphp
                                    @else
                                        @php $imgSrc = asset('assets/admin/img/no-image.png') @endphp
                                    @endif
                                    <img id="editImg-{{$data->id}}" src="{{$imgSrc}}" class="img-100w" data-id="{{$data->id}}" data-alias="ProductImage" />
                                </td>
                                <td>
                                    <div class="input-group">
										<input class="form-control" type="text" id="position-{{$data->id}}" value="{{ $data->position }}" onkeypress="return numbersonly(event)" maxlength="3">
										<span class="input-group-btn"><button class="btn btn-default btn-sm positionData" data-id="{{$data->id}}" data-alias="ProductVariant" type="button">Go</button></span>
									</div>
                                </td>
                                <td class="action">
                                    <a href="javascript:void(0)" class="text-info productVariantEdit" data-id="{{ $data->id }}" data-product_id="{{ $data->product_id }}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success': 'text-warning' }}" data-id="{{ $data->id }}" data-alias="ProductVariant" data-toggle="tooltip" data-placement="bottom" title="Status">
                                        <i class="fa fa-{{ $data->status?'check':'times' }}-circle"></i>
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
<div id="productVariantEditModal" class="modal fade" role="dialog">
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
<div id="productVariantAddModal" class="modal fade" role="dialog">
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
