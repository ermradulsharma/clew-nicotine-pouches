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
                    <h3 class="panel-title">{{$name}} &rArr; {{$page}}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@sortablelink('name','Name')</th>
                                <th>@sortablelink('email','Email')</th>
                                <th>@sortablelink('mobile_no','Mobile No.')</th>
                                <th>@sortablelink('review','Review')</th>
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->mobile_no }}</td>
                                <td>{{ $data->review }}</td>
                                <td class="action">
                                    <a href="javascript:void(0)" id="publishData-{{ $data->id }}" class="publishData {{ $data->status? 'text-success': 'text-warning' }}" data-id="{{ $data->id }}" data-alias="ProductReview" data-toggle="tooltip" data-placement="bottom" title="Status">
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
