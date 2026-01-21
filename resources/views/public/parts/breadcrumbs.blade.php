@if(isset($breadcrumbs) && is_array($breadcrumbs))
    <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $index => $crumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    @if(isset($crumb['url']) && !$loop->last)
                        <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                    @else
                        {{ $crumb['label'] }}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
