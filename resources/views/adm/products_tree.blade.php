@extends('adm.__layout')

@section('content')
{{--    <a href="/adm/categories/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>--}}

{{--Товаров всего: {{$products_count}} <br><br><br>--}}
количество товаров в разделах
<ul style="font-size: 120%;line-height: 170%;">
@foreach ($cat_tree as $cat)

    <li style="margin-left: 0;list-style-type: square;padding-left: 1em;">
        <b>{{ $cat->category }}</b>

    <ul style="margin-left: 1em;list-style-type: circle;padding-left: 1em;">
        @foreach ($cat->subcat as $scat)
            <li>
                {{ $scat->category }}
{{--                <a href="/adm/products_cat/{{$scat->id}}">{{ $scat->category }}</a>--}}
                <span style="font-size: 80%;">
                     {{ $scat->products->count() }}
{{--                    @if(!empty($count[$scat->id]))  {{ $count[$scat->id]->count }} @endif--}}
                </span>


        @endforeach
    </ul>


@endforeach
</ul>

@endsection
