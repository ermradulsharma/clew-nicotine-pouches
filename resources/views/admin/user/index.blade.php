@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.user.index') }}">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="searchKey" name="searchKey" placeholder="Search Keyword" value="{{ app('request')->input('searchKey') }}" mandatory />
                    </div>
                    <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.user.index') }}'">Reset</button>

                    <a href="{{ route('admin.user.export') }}" class="btn btn-default btn-sm pull-right">Download</a>
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
                                <th>@sortablelink('fname','Name')</th>
                                <th>@sortablelink('email','Email')</th>
                                
                                <th>@sortablelink('created_at','Date')</th>
                                
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                
                                <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                <td class="action">
                                <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success': 'text-warning' }}" data-id="{{ $data->id }}" data-alias="User" data-toggle="tooltip" data-placement="bottom" title="Status">
                                                <i class="fa fa-{{ $data->status?'check':'times' }}-circle"></i>
                                            </a>
                                    
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center"><strong>No data found.</strong></td>
                            </tr>
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