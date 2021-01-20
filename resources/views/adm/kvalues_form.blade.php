@extends('adm.__layout')

@section('content')

        <h3>Редактировать переменную <i>{{$kvalue->key}}</i></h3>


        {{ Form::model($kvalue, [
    'route' => ['adm.kvalues.update', $kvalue->id],
     'class' => 'ui form',
    'method' => 'patch']
) }}

<div class="fields">


    <div class="five wide field">

    <textarea name="text"  cols="90" rows="12" style="width: 100%; " required>{{$kvalue->value}}</textarea>

    </div>

</div>
    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}




@endsection
