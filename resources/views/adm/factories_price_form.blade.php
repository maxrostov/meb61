@extends('adm.__layout')

@section('content')

    <a href="/adm/factories">&larr; Фабрики</a>
        <h3>Обновить цены для {{$factory->factory}}</h3>

для связи использовать поле: <br>
        {{ Form::model($factory, [
    'route' => ['adm.factories.price_submit', $factory->id],
     'class' => 'ui form','files'=>true,
    'method' => 'post']
) }}


    <div class="field">
<input required checked type="radio" name="field" value="fabric_name"  id="label1">
<label for="label1" class="my_label"> Фабричное имя</label> <br>
<input type="radio" @if($field=='artikul') checked @endif name="field" value="artikul"  id="set_status_1">
<label for="set_status_1" class="my_label">Артикул</label> <br>
<br><br>
        <div class="field">
            <label>Файл XLSX</label>
            {!! Form::file('xlsx_file',['required'=>'required']) !!}     </div>
{{--        <label><input type="checkbox" name="is_large_excel">Большой файл (более 5000 позиций)</label>--}}
    </div>
    {!! Form::submit('Загрузить',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}



    @if($log)
        @if(is_array($log))
        <h4>Результат</h4>
        <table class="ui selectable celled small very compact table">
<thead>
<tr>
    <th>Поле {{$field}}</th>
    <th>Цена</th>
</tr>
</thead>

        @foreach($log as $row)
            <tr zstyle="@if($row['result']==0) background-color: rgba(255,198,181,0.5); @endif">
                <td>{{$row['label']}}
                    @if($row['result']) <i class="ui green small check icon"></i>
                    @else <br> <small style="background-color: rgba(255,86,89,0.13);">не найдено</small> @endif
                </td>
                <td>{{$row['price']}}</td>
            </tr>
        @endforeach
            @else
              Обработано! Позиций в прайсе -- {{$log}}
            @endif


            @else

                <h4>Формат заполнения XLSX</h4>
            1 стобец - артикул или фабричное название
{{--                (не обернутое в кавычки).--}}
                <br>
{{--            Разделитель - точка с запятой. <br>--}}
            2 столбец -- цена. <br><br>
{{--<pre>--}}
{{--Стол детский "МОДЕРН"<b>;</b>4800--}}
{{--Стул детский "МОДЕРН"<b>;</b>2400--}}
{{--Кровать детская "МОДЕРН"<b>;</b>5500--}}
{{--</pre>--}}
            @endif

        </table>

@endsection
