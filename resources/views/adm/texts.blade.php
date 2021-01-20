@extends('adm.__layout')

@section('content')

 <h2>Тексты</h2>

{{-- <a href="/adm/colors/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Добавить</a>--}}

    <table class="ui table">
{{--   <thead>--}}
{{--   <tr>--}}
{{--       <th>Цвет</th>--}}
{{--       <th></th>--}}
{{--   </tr>--}}
{{--   </thead>--}}

        <tbody>
@foreach($texts as $text)
        <tr>
            <td><a href="/adm/texts/{{$text->id}}/edit">{{$text->title}}</a></td>
            <td>

            </td>

        </tr>
@endforeach
        </tbody>
    </table>

@endsection
