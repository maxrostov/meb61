@extends('adm.__layout')

@section('content')

 <h2>Аттрибуты</h2>

 <a href="/adm/types/create" class="ui labeled icon button green"><i class="ui icon plus"></i>Создать группу</a>

    <table class="ui table">


        <ul>
@foreach($types as $item)

                <li style="font-size: 150%;line-height: 150%"><a href="/adm/types/{{$item->id}}/edit">{{$item->type}}</a>
                    <a href="/adm/values/{{$item->id}}/create" title="добавить в группу новое значение"><i class="ui plus icon"></i></a>
                </li>
<ul>
    @foreach($item->tvalues as $val)
        <li style=" "><a href="/adm/values/{{$val->id}}/edit">{{$val->value}}</a></li>

    @endforeach
</ul>   <br>
@endforeach
        </ul>
    </table>

@endsection
