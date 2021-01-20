@extends('adm.__layout')

@section('content')

    @if(isset($product))
{{--        <div class="ui breadcrumb">--}}
{{--            <a class="section" href="{{route('adm.products.index')}}">Каталог</a>--}}
{{--            <i class="right angle icon divider"></i>--}}
{{--            <span class="section">{{$product->category}}</span>--}}
{{--            <i class="right angle icon divider"></i>--}}
{{--            <a class="section" href="{{route('adm.products_cat',['cat_id'=>(session('last_visited_cat_id') ?? 7)])}}">{{session('last_visited_cat_name')}}</a>--}}
{{--            <i class="right angle icon divider"></i>--}}
{{--            <span class="section">редактировать</span>--}}
{{--            <i class="right angle icon divider"></i>--}}
{{--            <div class="active section">{{$product->name}}</div>--}}
{{--        </div>--}}
<a href="/mebel/{{$product->id}}" target="_blank" title="посмотреть на сайте" style="font-size: 90%;">
    <i class="share square outline grey small icon"></i>на сайте</a>
{{--<h4 style="margin-top: 0;">Редактировать товар</h4>--}}

        @if($product->parent_id) <br> <i> товар-модификация для <a href="{{route('adm.products.edit',[$product->parent])}}">{{$product->parent->name}}</a> </i> @endif

{{--        <h3>Редактировать товар</h3>--}}

        {{ Form::model($product, [
    'route' => ['adm.products.update', $product->id],'files' => true,
     'class' => 'ui form',
    'method' => 'patch']
) }}
    @else

        <h3>Добавить товар</h3>
        {{ Form::open(['route' => 'adm.products.store','class' => 'ui form','files' => true,]) }}
    @endif
<div style="display: flex;">

<div style="flex: 4 1 auto;">


<div class="fields">
    <div class="eight wide field">
        <label>Название</label>
        {!! Form::text('name',null,['autofocus'=>'autofocus','required'=>'required']) !!}
    </div>
    <div class="eight wide field">
        <label class="abbr"  title="из прайса фабрики, используется для автоматического обновления цен при отсутствии артикула">Фабричное название</label>
        {!! Form::text('fabric_name',null,['autofocus'=>'autofocus']) !!}
    </div>


</div>
<div class="fields">
    <div class="one field">
        <label>Цена</label>
        <input type="number" name="price" value="{{$product->price ?? 0}}">
    </div>

    <div class="three field">
        <label>Производитель</label>
        {!! Form::select('factory_id', $factories) !!}
    </div>

    <div class="one field">
        <label>Артикул</label>
        {!! Form::text('artikul') !!}
    </div>
    <div class="field">
        <label>Статус</label>
        {!! Form::select('status_id',$statuses,old('status_id'),['placeholder' => 'без статуса']) !!}
    </div>
</div>

{{--    <div class="fields">--}}
{{--        <div class=" field"><label>Модули</label>--}}
{{--            {!! Form::select('collection_id', $collections, null,['placeholder'=>'не входит...']) !!}--}}
{{--        </div>--}}
{{--    </div>--}}
<div class="fields">
    <div class="one field">
        <label>Материал корпус</label>
        {!! Form::select('material_body_id', $materials, ($product->material_body_id ?? 3)) !!}
    </div>
    <div class="one field">
        <label>Материал фасад</label>
        {!! Form::select('material_face_id', $materials,($product->material_face_id ?? 3)) !!}
    </div>
{{--    <div class="one field">--}}
{{--        <label>Основной цвет</label>--}}
{{--        {!! Form::select('color_id', $basic_colors, null, ['placeholder'=>'выберите цвет...']) !!}--}}
{{--    </div>--}}




    <div class="one field">
        <label>Оттенок корпус</label>
{{--        <input type="text" list="colors">--}}

        {!! Form::text('color_body',null,['list'=>'colors']) !!}
    </div>
    <div class="one field">
        <label>Оттенок фасад</label>
        {!! Form::text('color_face',null,['list'=>'colors']) !!}
    </div>
    <datalist id="colors">
        @foreach($colors as $color)
            <option value="{{$color}}">
        @endforeach
    </datalist>
</div>
    <div class="fields">

        <div class="ui fluid search four column selection dropdown">
            <input type="hidden" name="color_id" value="{{$product->color_id ?? ''}}">
            <i class="dropdown icon"></i>
            <div class="default text">выберите цвет...</div>
            <div class="menu">
                <div class="item" data-value="">[без цвета]</div>
                @foreach($basic_colors_image as $color)
                    <div class="item" data-value="{{$color->id}}">
                        @if($color->photo)
                        <img class='ui image' src='/{{$color->photo}}' style='width:50px;'>
                        @elseif($color->hex)
                            <i class="square full icon" style="font-size: 130%;color: {{$color->hex}}"></i>
                        @endif
                        {{$color->color}}</div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="fields">

        <div class="one field">
            <label>Вес (кг)</label>
            {!! Form::text('weight') !!}
        </div>
        <div class="one field">
            <label>Объем (m<sup>3</sup>)</label>
            {!! Form::text('volume') !!}
        </div>
        <div class="one field">
            <label>Упаковка (шт)</label>
            {!! Form::text('load') !!}
        </div>
        <div class="one field">
            <label>Ширина (мм)</label>
            {!! Form::text('width') !!}
        </div>
        <div class="one field">
            <label>Высота (мм)</label>
            {!! Form::text('height') !!}
        </div>
        <div class="one field">
            <label>Глубина (мм)</label>
            {!! Form::text('depth') !!}
        </div>

    </div>
    @if(isset($product))
    <div class="fields">


            <div class="six wide field">
                <label class="abbr"  title="для переключателя модификаций на странице товара">Коротко про модификацию</label>
                {!! Form::text('mod_name',null,['placeholder'=>'например "черный"']) !!}
            </div>

            <div class="field">
                <label class="abbr"  title="Укажите родительский товар">Модификация</label>
                {!! Form::select('parent_id',$siblings,old('parent_id'),['placeholder' => 'без родителя']) !!}
            </div>
    </div>


        @if($product->mod_siblings->count())
            <b>Все модификации</b> <br>
            @if($product->parent_id)
                <a style="font-weight:bold;" href="/adm/products/{{$product->parent->id}}/edit">{{$product->parent->name}}</a>
                   <a href="/mebel/{{$product->parent_id}}" target="_blank" title="родительская модификация"
                                                style="font-size: 90%;"><i class="share square outline grey small icon"></i></a><br>
            @endif
            @foreach($product->mod_siblings as $mod)
                @if($product->id==$mod->id)
                    {{$mod->name}}; {{$mod->mod_name}}  <br>
                @endif
                <a href="/adm/products/{{$mod->id}}/edit">{{$mod->name}}; {{$mod->mod_name}}</a> <br>
            @endforeach
            <br><br>
        @endif


            @if($product->children->count())
            <b>Имеет модификации</b> <br>
            @foreach($product->children as $mod)
            <a href="/adm/products/{{$mod->id}}/edit">{{$mod->name}}; {{$mod->mod_name}}</a> <br>
            @endforeach
            <br><br>
            @endif


    @endif

    <div class="field">
        <label>Описание</label>
        {!! Form::textarea('info') !!}
    </div>


    <div class="xfield">
        @foreach($types as $type)
            <b>{{$type->type}}:</b>

        @foreach($type->tvalues as $value)
                <label style="margin-right: 10px;margin-left: 5px;">
                    <input type="radio" name="tvalues[type{{$value->type_id}}]" value="{{$value->id}}"
                       @if(isset($product) AND $product->tvalues->contains('id',$value->id)) checked @endif>
                {{$value->value}}</label>
            @endforeach
            <label>   <input type="radio" name="tvalues[type{{$value->type_id}}]" value="">[убрать]</label>
            <br>

        @endforeach <br>
    </div>

    <div class="field">
        <label>Фотографии</label>

        <input type="file" name="_photos[]" multiple
               accept="image/png, image/jpeg">
    </div>



        @if(isset($product) AND $product->photos)
<div id="vue_photos">
    <input type=hidden id='get_photos_initial' data-json='@json($product->photos)'>
    <input type=hidden name='photos' v-bind:value='my_photos'>

    <draggable v-model="photos" group="people"
                ghost-class="vue_photos_ghost">
        <div v-for="(photo, index) in photos" class="product_photo" :class="[{product_photo_delete:photo.delete,product_photo_enlarge:photo.enlarge}]" :key="photo.id" style="    display: inline-block;">

            <img title="увеличить / уменьшить" :src="'/upload/'+photo.name"  @click="click_enlarge(index)">
            <i title="Удалить" @click="click_delete(index)"  :class="[{product_photo_trash_active:photo.delete}]" class="product_photo_trash ui grey trash icon"></i>
        </div>
    </draggable>
</div>
        @endif
    <br clear="all">

            <small>Фотографии можно менять местами перетягиванием.
                Увеличение и уменьшение - по клику.
                Для удаления - нажать на корзину</small>
    <br><br>

<div class="fields">

    <div class="field">

        <label>  {!! Form::checkbox('is_collection',1, ($product->is_collection ?? NULL)) !!} Коллекция (имеет модули)</label>

        @if(isset($product))
            @foreach($product->modules as $module)
            <a href="/adm/products/{{$module->id}}/edit">{{$module->name}}</a> <br>
        @endforeach
            @endif
    </div>



</div>

 @isset($product)
    @if( isset($product->factory->collections) AND $product->factory->collections->count()>0)
<i>Входит в коллекции</i>
    <div class="fields">
        <div class="xfield">
            @foreach($product->factory->collections as $collection)

<label><input type="checkbox" name="collections[{{$collection->id}}]" value="{{$collection->id}}"
@isset($product->parent_collections->keyBy('id')[$collection->id]) checked @endisset>{{$collection->name}}</label>
                <a href="/adm/products/{{$collection->id}}/edit"><i class="share square small icon"></i></a> <br>
            @endforeach
        </div>
    </div>


        @endif
    @endisset
{{--<label>{!! Form::checkbox('is_hidden',1, ($product->is_hidden ?? NULL) ) !!} Скрыть с сайта</label>--}}

{{--    <label><input type="checkbox" value="1" name="is_hidden" @if($product->is_hidden) checked @endif> Скрыть с сайта</label>--}}

    <br><br>



<button class="ui green tiny button" type="submit">Сохранить</button>
@if(isset($product))
<button class="ui blue tiny button" type="submit" name="save_and_mod_button" value="save_and_mod_button">Сохранить и создать модификацию</button>
<button class="ui violet tiny button" type="submit" name="save_and_copy_button" value="save_and_copy_button">Сохранить и копировать</button>


@endif
</div>
<div style="width: 340px;margin-left: 20px;margin-top: -36px;" class="js_select">
{!! Form::select('category_ids[]',$categories,($product->categories ?? old('category_ids')),
[
  'required'=>'required','id'=>'category_ids_multiselect',
'multiple'=>true,'style'=>'height:3700px;font-size:90%'] ) !!}
{{--        {!! Form::select('category_ids[]',$categories,($cat_id ?? $product->categories),['multiple'=>true,'style'=>'height:600px'] ) !!}--}}

    </div>
</div> {{--   close form fields wrapper--}}
    {!! Form::close() !!}


@if(isset($product))

    {!! Form::model($product, ['route' => ['adm.products.destroy',$product->id],
'onsubmit'=> "return confirm('действительно УДАЛИТЬ?');",
'style'=>'margin-top: 10px;','class' => 'ui form','method' => 'delete']) !!}
    <button type="submit" class='ui orange tiny right floated button'>Удалить</button>
    {!! Form::close() !!}



@endif







@endsection
