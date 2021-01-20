@extends('adm.__layout')

@section('content')


    @if(isset($color))
        <h3>Редактировать цвет</h3>


        {{ Form::model($color, [
    'route' => ['adm.colors.update', $color->id],
     'files' => true,
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else
        <h3>Добавить цвет</h3>
        {{ Form::open([
    'route' => 'adm.colors.store',
'files' => true,
'class' => 'ui form',]) }}
    @endif

    <div class="three fields">
        <div class="field">
            <label for="hex">Название</label>
            {!! Form::text('color',null,['autofocus'=>'autofocus']) !!}
        </div>
        <div class="field">
            <label for="hex">Цвет</label>
            <input data-jscolor="{required:false}"  name="hex" value="{{$color->hex ?? ''}}"></p>
            <label>Базовый цвет
                {!! Form::checkbox('status',1) !!} </label>

        </div>
           <div class="field">
            <label>Фотография</label>
{!! Form::file('_photo') !!}
            @if(isset($color) AND $color->photo)
                <img onclick="$(this).toggleClass('products_listing_img_popup')" class="products_listing_img"  src="/{{$color->photo}}" style="width: 100px;">
                <br>
                   <label><input type="checkbox" name="_photo_del"> Удалить фото </label>


               @endif
        </div>

    </div>




    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}


    @if(isset($color))
    {!! Form::model($color, ['route' => ['adm.colors.destroy',$color->id],'style'=>'margin-top: -31px;','class' => 'ui form','method' => 'delete']) !!}
    {!! Form::submit('Удалить',['class' => 'ui orange tiny right floated button']) !!}
    {!! Form::close() !!}
    @endif

@endsection
