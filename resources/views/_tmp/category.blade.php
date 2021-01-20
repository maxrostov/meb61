@extends('__layout')
@section('body')


    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="/main/{{$category->parent->id}}">{{$category->parent->category}}</a></li>
            @if($category->subparent AND $category->subparent->subparent_id)
                <li>    <a href="/cat/{{$category->subparent->subparent->id}}">{{$category->subparent->subparent->category}}</a>
                </li>
            @endif

            @if($category->subparent_id)
                <li>    <a href="/cat/{{$category->subparent->id}}">{{$category->subparent->category}}</a>
                </li>
            @endif


            <li style="color: #a8a8a8">&nbsp; {{$category->category}}</li>
        </ul>
    </nav>



    <h1 class="is-size-1  is-size-3-mobile">{{$category->category}}</h1>


    @if($category->subchildren)
        <div class="buttons my_navi">
@foreach($category->subchildren->where('is_hidden',NULL)->sortBy('category') as $subcat)
   <a href="/cat/{{$subcat->id}}" class="button is-info">{{$subcat->category}}</a>
    @endforeach
        </div>
@endif



    @include('_filters')

    <div style="line-height: 210%;word-spacing: 150%;user-select: none">
        <span style="border-bottom: 1px dashed grey;cursor:pointer;" onclick="$('#factories_list').toggle()">Производители</span>
        <span id="factories_list" @if(!isset(request()->factory_id)) style="display: none" @endif>@foreach($factories as $factory)
                @if(request()->factory_id == $factory->id)
                    <span
                        style="padding: 3px 8px;border: 1px solid mediumseagreen; background: #ebffe5;"> {{$factory->factory}}</span>
                @else
                    <a href="?factory_id={{$factory->id}}">{{$factory->factory}}</a>
                @endif
            @endforeach</span>
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
