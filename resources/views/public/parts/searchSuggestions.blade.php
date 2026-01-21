@foreach($products as $product)
    <div><a href="{{ route('productDetail', $product->slug) }}"><h4>{{$product->title}}</h4><p>{{ $product->short_description }}</p></a></div>
@endforeach


