@extends('adm.__layout')

@section('content')

 <h2>Баннеры</h2>

 <a href="/adm/banners/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>

    <table class="ui table">
   <thead>
   <tr>
       <th>Номер</th>
       <th>Картинка</th>
       <th>URL (Адрес)</th>
   </tr>
   </thead>

        <tbody>
@foreach($banners as $item)
        <tr>
            <td> <a href="/adm/banners/{{$item->id}}/edit">#{{$item->id}}</a></td>
            <td>
                <a href="/adm/banners/{{$item->id}}/edit">
                <img src="/sliders/{{$item->id}}.jpg" style="height:300px;"></a>

            </td>

            <td> <a target="_blank" href="{{$item->url}}">{{$item->url}}  </a></td>
        </tr>
@endforeach
        </tbody>
    </table>

@endsection
