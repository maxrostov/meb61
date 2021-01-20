@extends('adm.__layout')

@section('content')

                    <h2>Лог поисковых запросов</h2>

{{--Если найдено много товаров, то в выпадающем списке показано первые 32 товара.--}}

<table class="table">
    <thead>
    <th style="width: 70%">Запрос &rarr; Найдено</th><th>Дата, Юзер</th>
    </thead>
                        @foreach ($searches as $search)
<tr>
    <td>
        @if($search->found_ids)

                <span onclick="$('#found{{$search->id}}').toggle('fast')"
                      style="color: #1c7430;cursor:pointer;border-bottom: 1px dashed #1c7430;">
                    {{$search->query}}</span> &rarr; {{ count($search->found_ids) }}
        <div id="found{{$search->id}}" style="display: none;font-size: 80%;">
            @foreach (App\Product::find($search->found_ids) as $product)
                <a href="/mebel/{{$product->id}}" target="_blank">
                    {{$product->name}} </a>
               <br>
            @endforeach </div>
        @else<span style="color: #b75151;">{{$search->query}}</span> <span style="color: #ccc;">не найдено</span>@endif
    </td>
    <td style="font-size: 80%;">
        {{$search->created_at}}
{{--        ({{ \Carbon\Traits\Date::parse($search->created_at)->diffForHumans()}})--}}
        <br>
            <span id="ip{{$search->id}}" class="js_search" style="color: #92929c;"
                  onclick="$('#ip{{$search->id}}').text(useragent_human('{{$search->useragent}}'))">
                {{$search->useragent}}</span><br>
        {{$search->ip}}
</td>
</tr>




    @endforeach

</table>
                            {{ $searches->links('vendor/pagination/semantic-ui') }}


@endsection
