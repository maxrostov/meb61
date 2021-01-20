<div style="position:fixed;padding: 5px;bottom: 0;left: 20%;font-size: 90%;background-color: rgba(255,255,255,0.83);" class="fields">

    <legend style="position: absolute; top: -15px;left: 5px;">действия с отмеченными товарами</legend>

    <div class="field">
        <select name="selected_action">
            <option value="0">Сменить статус...</option>
            <option value="set_status_1">Установить статус "Не проверено"</option>
            <option value="set_status_2">Установить статус "Проверено"</option>
            <option value="set_status_3">Установить статус "Недочеты"</option>
            <option value="set_status_4">Установить статус "Скрыто"</option>
            <option value="set_price_zero">Обнулить цену</option>
            <option value="delete_item">Удалить</option>
        </select>
    </div>
    <div class="field">

        {!! Form::select('selected_category_id',$categories,null,['placeholder' => 'Добавить в раздел...']) !!}
    </div>

    <div class="field">
       @if($collections)
        {!! Form::select('selected_collection_id',$collections,null,['placeholder' => 'Добавить в коллекцию...']) !!}
   @else
           <div style="font-size: 80%;line-height: 150%;">для добавления в коллекции <br> выберите фабрику</div>
        @endif
    </div>

    <div class="field">  <button name="selected_submit" value="selected_submit" class="ui grey tiny button" type="submit">Сделать</button>
    </div>
</div>
