@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.ingredient.index') }}">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="searchKey" name="searchKey" placeholder="Search Keyword" value="{{ app('request')->input('searchKey') }}" mandatory />
                    </div>
                    <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.ingredient.index') }}'">Reset</button>

                    <a href="{{ route('admin.ingredient.create') }}" class="btn btn-default btn-sm pull-right">Add</a>
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
                                <th>@sortablelink('title','Title')</th>
                                <th>Description</th>
                                <th class="w150px">Image</th>
                                <th class="w120px">@sortablelink('position','Position')</th>
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description }}</td>
                                <td>
                                    @if($data->image)
                                        @php $imgSrc = asset('storage/ingredient/'.$data->image); @endphp
                                    @else
                                        @php $imgSrc = asset('assets/admin/img/no-image.png') @endphp
                                    @endif
                                    <img src="{{$imgSrc}}" class="img-80w" />
                                </td>
                                <td>
									<form id="positionForm" name="positionForm" action="{{ route('admin.ingredient.position') }}" method="post">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="position" value="{{ $data->position }}" onkeypress="return numbersonly(event)" maxlength="3" />
                                            <input type="hidden" name="id" value="{{ $data->id }}" />
                                            @csrf
                                            <span class="input-group-btn"><button type="submit" class="btn btn-default btn-sm">Go</button></span>
                                        </div>
                                    </form>
                                </td>
                                <td class="action">
                                    <a href="{{route('admin.ingredient.edit', $data->id)}}" class="text-info" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success': 'text-warning' }}" data-id="{{ $data->id }}" data-alias="Ingredient" data-toggle="tooltip" data-placement="bottom" title="Status">
                                        <i class="fa fa-{{ $data->status?'check':'times' }}-circle"></i>
                                    </a>
                                    <!-- <a href="javascript:void(0)" class="deleteData text-danger" data-id="{{ $data->id }}" data-alias="Ingredient" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a> -->
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
@endsection
