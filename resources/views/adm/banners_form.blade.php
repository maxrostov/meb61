@extends('adm.__layout')

@section('content')


    @if(isset($banner))
        <h3>Редактировать баннер</h3>

        {{ Form::model($banner, [
    'route' => ['adm.banners.update', $banner->id],
     'files' => true,
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else
        <h3>Добавить баннер</h3>
        {{ Form::open([
    'route' => 'adm.banners.store',
'files' => true,
'class' => 'ui form',]) }}
    @endif
    Рекомендуемый размер - 1330*400 пикселей

    <div class="three fields">
        <div class="field">
            <label>Фотография</label>


            @if(isset($banner))
                {!! Form::file('_photo',['accept'=>".jpg"]) !!}

                <img height="300" src="/sliders/{{$banner->id}}.jpg">
                <br>
                @else
                {!! Form::file('_photo',['accept'=>".jpg",'required'=>'required']) !!}

            @endif
        </div>
        <div class="field">
            <label for="url">URL (ссылка)</label>
            {!! Form::text('url') !!}
        </div>



    </div>




    {!! Form::submit('Сохранить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}


    @if(isset($banner))
    {!! Form::model($banner, ['route' => ['adm.banners.destroy',$banner->id],'onsubmit'=> "return confirm('действительно УДАЛИТЬ?');",'style'=>'margin-top: -31px;','class' => 'ui form','method' => 'delete']) !!}
    {!! Form::submit('Удалить',['class' => 'ui orange tiny right floated button']) !!}
    {!! Form::close() !!}
    @endif

@endsection
