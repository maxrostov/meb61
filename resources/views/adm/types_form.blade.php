@extends('adm.__layout')

@section('content')


    @if(isset($type))
        <h3>Редактировать аттрибут</h3>


        {{ Form::model($type, [
    'route' => ['adm.types.update', $type->id],
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else
        <h3>Добавить аттрибут</h3>
        {{ Form::open([
    'route' => 'adm.types.store',
'class' => 'ui form',]) }}
    @endif

    <div class="three fields">
        <div class="field">
            <label for="hex">Название</label>
            {!! Form::text('type',null,['autofocus'=>'autofocus']) !!}
        </div>
        <div class="field">


        </div>


    </div>




    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}


    @if(isset($type))
    {!! Form::model($type, ['route' => ['adm.types.destroy',$type->id],'style'=>'margin-top: -31px;','class' => 'ui form','method' => 'delete']) !!}
    {!! Form::submit('Удалить',['class' => 'ui orange tiny right floated button']) !!}
    {!! Form::close() !!}
    @endif

@endsection
