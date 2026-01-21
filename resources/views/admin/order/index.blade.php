@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.order.index') }}">
                    {{--
                    <div class="form-group">
                        <select class="form-control input-sm" id="payment_mode" name="payment_mode" mandatory>
                            <option value="">Payment Mode</option>
                            <option value="Online" {{(app('request')->input('payment_mode')=='Online')?'selected':''}}>Online</option>
                            <option value="COD" {{(app('request')->input('payment_mode')=='COD')?'selected':''}}>COD</option>
                        </select>
                    </div>
                    --}}
                    <div class="form-group">
                        <select class="form-control input-sm" id="order_status" name="order_status" mandatory>
                            <option value="">Order Status</option>
                            <option value="New" {{(app('request')->input('order_status')=='New')?'selected':''}}>Order New</option>
                            <option value="Packed" {{(app('request')->input('order_status')=='Packed')?'selected':''}}>Order Packed</option>
                            <option value="Shipped" {{(app('request')->input('order_status')=='Shipped')?'selected':''}}>Order Shipped</option>
                            <option value="Delivered" {{(app('request')->input('order_status')=='Delivered')?'selected':''}}>Order Delivered</option>
                            <option value="Cancelled" {{(app('request')->input('order_status')=='Cancelled')?'selected':''}}>Order Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control input-sm" id="payment_status" name="payment_status" mandatory>
                            <option value="">Payment Status</option>
                            <option value="Paid" {{(app('request')->input('payment_status')=='Paid')?'selected':''}}>Paid</option>
                            <option value="Pending" {{(app('request')->input('payment_status')=='Pending')?'selected':''}}>Pending</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" id="searchKey" name="searchKey" placeholder="Search Keyword" value="{{ app('request')->input('searchKey') }}" mandatory />
                    </div>
                    <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.order.index') }}'">Reset</button>
                    {{--
                    <a href="{{ route('admin.order.import') }}" class="btn btn-default btn-sm pull-right">Import</a>
                    --}}
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
                                <th>@sortablelink('id','Order ID')</th>
                                <th>@sortablelink('name','Name')</th>
                                <th>@sortablelink('state','State')</th>
                                <th>@sortablelink('grand_total','Amount')</th>
                                <th>@sortablelink('order_status','Order')</th>
                                <th>@sortablelink('payment_status','Payment')</th>
                                <th>@sortablelink('created_at','Date')</th>
                                <th class="w150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_data as $data)
                            <tr id="row-{{ $data->id }}">
                                <td>{{ (($all_data->currentPage() - 1 ) * $all_data->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->state }}</td>
                                <td>${{ number_format($data->grand_total-$data->coupon_amount, 2) }}</td>
                                <td>{{ $data->order_status }}</td>
                                <td>{{ $data->payment_status }}</td>
                                <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                <td class="action">
                                    {{---
                                    <a href="{{route('admin.order.edit', $data->id)}}" class="text-info" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    --}}
                                    <a href="{{route('admin.order.invoice', $data->id)}}" data-toggle="tooltip" data-placement="bottom" title="Invoice" target="_blank">
                                        <i class="fa fa-file-text"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr><td colspan="10" class="text-center"><strong>No data found.</strong></td></tr>
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
<div id="orderRequeryModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="title" class="modal-title">Order Response</h4>
            </div>
            <div class="p10px">
                <table class="table table-striped">
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
