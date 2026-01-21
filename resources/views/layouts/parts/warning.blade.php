<div class="warning-box">WARNING:This product contains nicotine. <br />
    Nicotine is an addictive chemical.</div>
@php $tickers = \App\Models\Ticker::where('status', 1)->orderBy('position', 'asc')->get(); @endphp
@if ($tickers->count())
    <div class="anoucement-bar">
        @foreach ($tickers as $ticker)
            <div>{{ $ticker->title }}</div>
        @endforeach
    </div>
@endif
