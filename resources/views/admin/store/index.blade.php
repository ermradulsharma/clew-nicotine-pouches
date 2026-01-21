@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.store.index') }}" style="display: flex; justify-content: space-between;">
                    <div>
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="searchKey" name="searchKey" placeholder="Search Keyword" value="{{ app('request')->input('searchKey') }}" mandatory />
                        </div>
                        <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                        <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.store.index') }}'">Reset</button>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.store.template') }}" class="btn btn-default btn-sm pull-right">Sample</a>
                        <a href="{{ route('admin.store.importView') }}" class="btn btn-default btn-sm pull-right">Import</a>
                        {{-- <a href="{{ route('admin.store.export') }}" class="btn btn-default btn-sm pull-right">Export</a> --}}
                    </div>
                    
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
                                <th>@sortablelink('name','Name')</th>
                                <th>Address</th>
                                <th>@sortablelink('city','City')</th>
                                <th>@sortablelink('state','State')</th>
                                <th>@sortablelink('zip','Zip')</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->address }}</td>
                                <td>{{ $data->city }}</td>
                                <td>{{ $data->state }}</td>
                                <td>{{ $data->zip }}</td>
                                <td class="action">
                                    <a href="javascript:void(0)" class="deleteData text-danger" data-id="{{ $data->id }}" data-alias="Store" data-toggle="tooltip" data-placement="bottom" title="Delete">
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
@endsection
