@extends('adm.__layout')

@section('content')

 <h2>Настройки</h2>

{{-- <a href="/adm/banners/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>--}}

    <table class="ui table">
   <thead>
   <tr>
       <th>Переменная</th>
       <th>Значение</th>

   </tr>
   </thead>

        <tbody>
@foreach($kvalues as $item)
        <tr>
            <td>{{$item->key}} <br>
                <a href="/adm/kvalues/{{$item->id}}/edit">Изменить</a>
            </td>

            <td>
                <pre>{{$item->value}}</pre>
            </td>
        </tr>
@endforeach
        </tbody>
    </table>

@endsection
