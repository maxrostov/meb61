@extends('adm.__layout')

@section('content')

 <h2>Цвета</h2>

 <a href="/adm/colors/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>

    <table class="ui table">
{{--   <thead>--}}
{{--   <tr>--}}
{{--       <th>Цвет</th>--}}
{{--       <th></th>--}}
{{--   </tr>--}}
{{--   </thead>--}}

        <tbody>
@foreach($colors as $item)
        <tr>
            <td><a href="/adm/colors/{{$item->id}}/edit">{{$item->color}}</a></td>
            <td>
                @if($item->photo)
                <img onclick="$(this).toggleClass('products_listing_img_popup')" class="products_listing_img"  src="/{{$item->photo}}" style="width: 100px;">
                @endif
            </td>

            <td style="background-color: {{$item->hex}};"></td>
            <td>@if($item->status==1) базовый цвет @endif</td>
        </tr>
@endforeach
        </tbody>
    </table>

@endsection
