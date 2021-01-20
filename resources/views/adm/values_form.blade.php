@extends('adm.__layout')

@section('content')


    @if(isset($value))
        <h3>Редактировать</h3>

        <i>
            Группа {{$value->type->type}}: @foreach($value->type->tvalues as $val) {{$val->value}}; @endforeach
        </i>


        {{ Form::model($value, [
    'route' => ['adm.values.update', $value->id ],
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else
        <h3>Добавить в группу {{$type->type}}</h3>

        <i>
            Группа {{$type->type}}: @foreach($type->tvalues as $val) {{$val->value}}; @endforeach
        </i>

        {{ Form::open([
    'route' => ['adm.values.store', $type->id],
'class' => 'ui form',]) }}

    @endif

    <div class="three fields">
        <div class="field">
            <label>значение</label>
            {!! Form::text('value',null,['autofocus'=>'autofocus']) !!}
        </div>
        <div class="field">


        </div>


    </div>




    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}


    @if(isset($value))
    {!! Form::model($value, ['route' => ['adm.values.delete',$value->id],
'style'=>'margin-top: -31px;','class' => 'ui form','method' => 'delete']) !!}
    {!! Form::submit('Удалить',['class' => 'ui orange tiny right floated button']) !!}
    {!! Form::close() !!}
    @endif



@endsection
