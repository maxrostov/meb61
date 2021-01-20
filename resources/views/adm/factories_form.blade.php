@extends('adm.__layout')

@section('content')


    @if(isset($factory))
        <h3>Редактировать фабрику</h3>


        {{ Form::model($factory, [
    'route' => ['adm.factories.update', $factory->id],
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else
        <h3>Добавить фабрику</h3>
        {{ Form::open(['route' => 'adm.factories.store','class' => 'ui form',]) }}
    @endif
<div class="fields">


    <div class="five wide field">
        <label for="">Название фабрики</label>
    {!! Form::text('factory',null,['required'=>'required','autofocus'=>'autofocus']) !!}
    </div>
    <div class="three wide field">
        <label for="">Наценка</label>
        {!! Form::number('margin',null,
['required'=>'required',
'placeholder'=>'наценка',
'min'=>0.1,
'max'=>10,
'step'=>0.01]) !!}
    </div>
</div>
    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}


    @if(isset($factory))
    {!! Form::model($factory, ['route' => ['adm.factories.destroy',$factory->id],
'onsubmit'=> "return confirm('действительно УДАЛИТЬ?');",
'style'=>'margin-top: -31px;','class' => 'ui form','method' => 'delete']) !!}
    {!! Form::submit('Удалить',['class' => 'ui orange tiny right floated button']) !!}
    {!! Form::close() !!}
    @endif

@endsection
