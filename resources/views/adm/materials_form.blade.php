@extends('adm.__layout')

@section('content')


    @if(isset($material))
        <h3>Редактировать материал</h3>


        {{ Form::model($material, [
    'route' => ['adm.materials.update', $material->id],
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else
        <h3>Добавить материал</h3>
        {{ Form::open(['route' => 'adm.materials.store','class' => 'ui form',]) }}
    @endif

    <div class="field">
    {!! Form::text('material',null,['autofocus'=>'autofocus']) !!}
    </div>
    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}


    @if(isset($material))
    {!! Form::model($material, ['route' => ['adm.materials.destroy',$material->id],'style'=>'margin-top: -31px;','class' => 'ui form','method' => 'delete']) !!}
    {!! Form::submit('Удалить',['class' => 'ui orange tiny right floated button']) !!}
    {!! Form::close() !!}
    @endif

@endsection
