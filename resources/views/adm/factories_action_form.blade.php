@extends('adm.__layout')

@section('content')

    <a href="/adm/factories">&larr; Фабрики</a>
        <h3>Действия для фабрики {{$factory->factory}}</h3>


        {{ Form::model($factory, [
    'route' => ['adm.factories.actions_submit', $factory->id],
     'class' => 'ui form',
    'method' => 'post']
) }}


    <div class="field">
<input type="radio" name="action" value="set_zero_price"  id="set_zero_price">
        <label for="set_zero_price" class="my_label"> Обнулить цены</label> <br>
        всем товарам этой фабрики будет установлена цена "0", следовательно на сайте будет выводится " цена обновляется "
        <br><br><br>

        <input type="radio" name="action" value="set_price_margin"  id="set_price_margin">
        <label for="set_price_margin" class="my_label"> Обновить цены</label>
        <input type="number"  style="width: 6em;" name="margin" value="1" min="0.01" max="10"  step="0.01" placeholder="коэффициент">
        <br>
        всем товарам этой фабрики цена будет умножена на коэффициент.

        <br><br><br>


        <input type="radio" name="action" value="set_status_1"  id="set_status_1">
        <label for="set_status_1" class="my_label">"Не проверено"</label> <br>
        всем товарам будет установлен статус "Не проверено"
        <br><br>

        <input type="radio" name="action" value="set_status_2"  id="set_status_2">
        <label for="set_status_2" class="my_label">"Проверено"</label> <br>
        всем товарам будет установлен статус "Проверено")
        <br><br>

        <input type="radio" name="action" value="set_status_3"  id="set_status_3">
        <label for="set_status_3" class="my_label">"Недочеты"</label> <br>
        всем товарам будет установлен статус "Недочеты")
        <br><br>

        <input type="radio" name="action" value="set_status_4"  id="set_status_4">
        <label for="set_status_4" class="my_label">Скрыть товары</label> <br>
        всем товарам будет установлен статус "Скрыто")
        <br><br>


        {{--        <input type="radio" name="action" value="unset_is_hidden"  id="unset_is_hidden">--}}
{{--        <label for="unset_is_hidden" class="my_label">Показать товары</label> <br>--}}
{{--        все товары будут показаны на сайте (будет сброшена галочка "Скрыть с сайта")--}}
{{--        <br><br><br>--}}
    </div>
    {!! Form::submit('Сделать',['class' => 'ui green tiny button']) !!}

    {!! Form::close() !!}



@endsection
