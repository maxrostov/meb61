
<div class="field">
    <label>Описание</label>
    {!! Form::textarea('props',$item->props,['rows'=>4]) !!}
</div>
<div class="field">
    <label>Комментарий</label>
    {!! Form::textarea('comment',$item->comment,['rows'=>2]) !!}
</div>

<div class="field">
    <div class="ui checkbox">
        <input type="checkbox" name="feed_free" id="feed_free" value="1"
        <?php if($item->feed_free==1) echo'checked' ?>>
        <label for="feed_free">Бесплатный фид</label>
    </div>

    <div class="ui checkbox">
        <input type="checkbox" name="feed_paid" id="feed_paid" value="1"
        <?php if($item->feed_paid==1) echo'checked' ?>>
        <label for="feed_paid">Платный фид</label>
    </div>
</div>


<div class="field">
 <label>Фотографии</label>

    <input type="file"name="_photos[]" multiple
           accept="image/png, image/jpeg">
</div>
@if($item->photos)
    <input type=hidden  id="photos"  name='photos' value='{{$item->photos}}'>
    <div id="sortable" class="jspopupwrap_item">
        @foreach (explode(',',$item->photos) as $pic)

            <div id="pic_item{{$loop->index}}" onclick="toggle_del_item('pic_item{{$loop->index}}')" class="pic_item" data-id='{{$pic}}'>
                <img x-onclick="toggle_del('pic{{$loop->index}}')"  data-file='{{$pic}}' id="pic{{$loop->index}}" width=170 src='/upload/{{$pic}}'><br>
            </div>

        @endforeach
    </div><br><br clear="all"><br>
    <small>Фотографии можно менять местами перетягиванием. Для удаления - нажать на фото</small>
{{--    <div class="ui icon tiny button" data-tooltip="Фотографии можн менять местами перетягиванием. Для удаления - нажать на фото">--}}
{{--        <i class="help icon"></i>    </div>--}}
@endif
<br>

<button class="ui green button" type="submit">Сохранить</button>
<div style="float:right;text-align: right;font-size: 90%;">Внесено в базу: {!! date('d-m-y',strtotime($item->created_at)) !!} <br>
    Обновлено: {!! date('d-m-y',strtotime($item->updated_at)) !!}
    <br>
    <input type="checkbox" name="delete" id="delete" style="vertical-align: baseline;margin-right: 4px;">
    <label for="delete">Удалить</label>
</div>
<br> <br> <br> <br>
