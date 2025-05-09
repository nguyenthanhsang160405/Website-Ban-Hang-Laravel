@extends('layout.chung')

@section('content')
    <p>{{ $product['name'] }}</p>
    <p>{{ $product['price'] }}</p>
    <p>{{ $product['description'] }}</p>
    @if (empty($sang2))
        <p>{{ $sang2 }}</p>
    @elseif($sang2 == 'sang')
        <p>{{ $sang2 }}</p>
    @else
        <p>Tên thì không rỗng</p>
    @endif
    @unless(empty($sang2))
        <p>{{ $sang2 }}</p>
    @endunless
    @empty($sang2)
        <p>{{ $sang2 }}</p>
    @endempty
    @isset($sang2)
        <p>isset tồn tại</p>
    @endisset
    @switch($sang2)
        @case('Sang')
            <p>cc</p>
            @break
        
        @case('sang')
            <p>cc1</p>
            @break
    
        @default
            
    @endswitch
    @for ($i = 0; $i < 10; $i++)
        <p>{{ $i }}</p>
    @endfor
    <a href="{{ route('products') }}">Link to Product</a>
@endsection
    