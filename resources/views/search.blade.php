@extends('__layout')
@section('body')


    <h1 class="is-size-1">Поиск</h1>

    @if($products)
    <div style="text-align: right;margin-right: 2em;text-transform: uppercase;font-size: 75%;">
        <span style="color: #a4a4a4">Показать:</span> <br>

        @if(request()->order_by=='price_desc')
            <a href="{{$products->withQueryString()->url(1)}}&order_by=price">Сначала дешевле</a>
            <span>сначала дороже</span>
            @elseif(request()->order_by=='price')
            <span>сначала дешевле</span>
            <a style="border-bottom: 1px solid rgba(75,156,249,0.65);" href="{{$products->withQueryString()->url(1)}}&order_by=price_desc">Сначала дороже</a>
@else
{{--            <span>показано по релевантности</span> <br>--}}
            <a href="{{$products->withQueryString()->url(1)}}&order_by=price">Сначала дешевле</a>
            <a style="border-bottom: 1px solid rgba(75,156,249,0.65);" href="{{$products->withQueryString()->url(1)}}&order_by=price_desc">Сначала дороже</a>

        @endif
    </div>
@endif
{{--    @include('_filters')--}}


        <div style="
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: flex-start;
	align-items: stretch;
	align-content: stretch;
">
            @forelse ($products as $product)
    @include('_item')

            @empty
            ничего не найдено
            @endforelse


        </div>
    @if($products) {{ $products->withQueryString()->links() }} <br>
    @endif


@endsection
