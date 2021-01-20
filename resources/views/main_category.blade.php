@extends('__layout')
@section('body')

    <h1 class="is-size-1  is-size-3-mobile">{{$main_category->category}}</h1>


<div class="buttons my_navi">
@foreach($main_category->children
->where('subparent_id',NULL)->where('is_hidden',NULL)->sortBy('category') as $cat)
  <a href="/cat/{{$cat->id}}" class="button  is-info">{{$cat->category}}</a>
@endforeach
</div>

    @include('_filters')

    @include('_filter_factory')


    <div class="category_info">
    {{$main_category->info}}
    </div>

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
нет товаров
@endforelse


</div>
{{ $products->withQueryString()->links() }} <br>


@endsection
