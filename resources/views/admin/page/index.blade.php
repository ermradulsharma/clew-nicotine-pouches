@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.page.index') }}">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="searchKey" name="searchKey" placeholder="Search Keyword" value="{{ app('request')->input('searchKey') }}" mandatory />
                    </div>
                    <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.page.index') }}'">Reset</button>

                    <a href="{{ route('admin.page.create') }}" class="btn btn-default btn-sm pull-right">Add</a>
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
                                <th class="w150px">Image</th>
                                <th class="w150px">Banners</th>
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->title }}</td>
                                <td>
                                    @if($data->image)
                                        @php $imgSrc = asset('storage/page/'.$data->image); @endphp
                                    @else
                                        @php $imgSrc = asset('assets/admin/img/no-image.png') @endphp
                                    @endif
                                    <img src="{{$imgSrc}}" class="img-80w" />
                                </td>
                                <td>
                                    <a href="{{route('admin.page.banners.index', $data->id)}}" class="btn btn-primary btn-xs">View <span class="badge">{{ count($data->banners) }}</span></a>
                                </td>
                                <td class="action">
                                    <a href="{{route('admin.page.edit', $data->id)}}" class="text-info" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr><td colspan="4" class="text-center"><strong>No data found.</strong></td></tr>
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
