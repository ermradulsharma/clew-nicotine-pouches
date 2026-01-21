@extends('layouts.admin')

@section('content')
@include('layouts.parts.admin.header')
@include('layouts.parts.admin.sidebar')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="search-form">
                <form id="searchForm" name="searchForm" class="form-inline" action="{{ route('admin.dashboard') }}">
                    <div class="form-group">
                        <input type="text" name="from_date" id="from_date" class="form-control input-sm" value="{{ $from_date }}" mandatory readonly />
                        <input type="text" name="to_date" id="to_date" class="form-control input-sm" value="{{ $to_date }}" mandatory readonly />
                    </div>
                    <button type="submit" id="searchNow" class="btn btn-default btn-sm" value="searchNow">Search</button>
                    <button type="button" class="btn btn-default btn-sm" onClick="window.location='{{ route('admin.dashboard') }}'">Reset</button>
                </form>
            </div>
            <div class="panel panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title">Sales Between <span>{{ date('d M, Y', strtotime($from_date)) }}</span> to <span>{{ date('d M, Y', strtotime($to_date)) }}</span></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="metric">
                                <p>
                                    <span class="number">Orders</span>
                                    <span class="title">Numbers: {{ \App\Models\Order::where('payment_status', 'Paid')->count() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection