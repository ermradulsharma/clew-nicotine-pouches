@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form" style="overflow: initial;">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.product.index') }}">
                    <div class="form-group">
                        <select class="form-control input-sm" id="category_id" name="category_id" mandatory>
                            <option value="">Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" {{ ($category->id==app('request')->input('category_id'))?'selected':'' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="searchKey" name="searchKey" placeholder="Search Keyword" value="{{ app('request')->input('searchKey') }}" mandatory />
                    </div>
                    <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.product.index') }}'">Reset</button>
                    <a href="{{ route('admin.product.create') }}" class="btn btn-default btn-sm pull-right">Add</a>
                </form>
            </div>
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>@sortablelink('title','Title')</th>
                                <th>@sortablelink('sku_code','SKU Code')</th>
                                <th>Images</th>
                                <th>Variants</th>
                                <th>Similar</th>
                                <th class="w120px">@sortablelink('position','Position')</th>
                                <th class="w180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->category->title }}</td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->sku_code }}</td>
                                <td>
                                    <a href="{{route('admin.product.images.index', $data->id)}}" class="btn btn-primary btn-xs">View <span class="badge">{{ count($data->images) }}</span></a>
                                </td>
                                <td>
                                    <a href="{{route('admin.product.variants.index', $data->id)}}" class="btn btn-primary btn-xs">View <span class="badge">{{ count($data->variants) }}</span></a>
                                </td>
                                <td>
                                    <a href="{{route('admin.product.similar.index', $data->id)}}" class="btn btn-primary btn-xs">View <span class="badge">{{ count($data->similar) }}</span></a>
                                </td>
                                <td>
									<form id="positionForm" name="positionForm" action="{{ route('admin.product.position') }}" method="post">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="position" value="{{ $data->position }}" onkeypress="return numbersonly(event)" maxlength="3" />
                                            <input type="hidden" name="id" value="{{ $data->id }}" />
                                            @csrf
                                            <span class="input-group-btn"><button type="submit" class="btn btn-default btn-sm">Go</button></span>
                                        </div>
                                    </form>
                                </td>
                                <td class="action">
                                    <a href="javascript:void(0)" id="showOnCart-{{ $data->id }}" class="showOnCart text-warning" data-id="{{ $data->id }}" data-toggle="tooltip" data-placement="bottom" title="Cart">
                                        <i class="fa fa-{{$data->showOnCart?'bell':'bell-o'}}"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="featuredData-{{ $data->id }}" class="featuredData text-warning" data-id="{{ $data->id }}" data-alias="Product" data-toggle="tooltip" data-placement="bottom" title="Featured">
                                        <i class="glyphicon glyphicon-{{$data->featured?'star':'star-empty'}}"></i>
                                    </a>
                                    <a href="{{route('admin.product.edit',$data->id)}}" class="text-info" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success':'text-warning' }}" data-id="{{ $data->id }}" data-alias="Product" data-toggle="tooltip" data-placement="bottom" title="Status">
                                        <i class="fa fa-{{ $data->status?'check':'times' }}-circle"></i>
                                    </a>
                                    {{--
                                    <a href="javascript:void(0)" class="deleteData text-danger" data-id="{{ $data->id }}" data-alias="Product" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    --}}
                                </td>
                            </tr>
                            @empty
                                <tr><td colspan="8" class="text-center"><strong>No data found.</strong></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div id="paginationSection">{{ $all_data->appends(request()->except('page'))->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
