@extends('adm.__layout')

@section('content')

 <h2>Материалы</h2>

 <a href="/adm/materials/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>

    <table class="ui table">
{{--   <thead>--}}
{{--   <tr>--}}
{{--       <th>Цвет</th>--}}
{{--       <th></th>--}}
{{--   </tr>--}}
{{--   </thead>--}}

        <tbody>
@foreach($materials as $item)
        <tr>
            <td><a href="/adm/materials/{{$item->id}}/edit">{{$item->material}}</a></td>
            <td></td>
        </tr>
@endforeach
        </tbody>
    </table>

@endsection
