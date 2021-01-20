@extends('adm.__layout')
@section('content')



    <div class="item" style="position:absolute;top: 25px;left: 200px">
        <a href="{{route('adm.products.create')}}" class="ui labeled icon tiny button green">
            <i class="ui icon plus"></i>Добавить товар</a>
    </div>

    <form id="flat_search" class="ui form" action="{{route('adm.products.index')}}">
    @include('adm._products_search')

<div style="display: flex">
    <div  style="width: 80%">

        <datalist id="colors_suggest">
            @foreach($colors_suggest as $color)
                <option value="{{$color}}">
            @endforeach
        </datalist>

        <span style="font-size: 90%;">Показано: {{$products->count()}}, всего: {{$products->total()}}</span>

        <table id="products_table" class="ui very striped compact small table" style="">
            <thead>
            <tr>
                <th style="width: 30em;">Товар, артикул</th>
                <th>Цена розн., <br>
                    цена базовая, <br>
                    статус</th>
                <th style="width: 7em;">
                    Ширина <br>
                    Высота  <br>
                    Глубина
                </th>

                <th>Цвет, Фабрика</th>
                <th>Корпус; Фасад</th>
                <th>Фото</th>
                <th>Дата создания <br>
                <span onclick="select_all()" style="border-bottom: 1px dashed gray;cursor:pointer;">выбрать все</span></th>
            </tr>
            </thead>
            @foreach ($products as $product)
                @php
                    $last_num = substr($product->id, -1);
                    $pre_last_num = substr($product->id, -2,1);

                @endphp

<tr class="js_parent{{$product->id}}">
<td @if($product->children->count()>0) class="products_table_family family{{$last_num}} family_border{{$last_num}}" @endif>
<a class="@if($product->is_collection) collection_main_item @endif @if($product->status_id==4) is_hidden @endif" target="_blank" href="/adm/products/{{$product->id}}/edit">
{{$product->name}}</a>
@if($product->is_collection)  <span style="text-transform:uppercase;font-size: 70%;">коллекция</span> @endif <br>
<input type="text" value="{{$product->fabric_name}}" class="inline_value js_inline_ajax_value" data-field="fabric_name" data-product_id="{{$product->id}}" placeholder="фабричное название">
<input type="text" value="{{$product->artikul}}"  class="inline_value js_inline_ajax_value" data-field="artikul" data-product_id="{{$product->id}}" placeholder="артикул">
    <textarea cols="30" rows="1" data-field="info" data-product_id="{{$product->id}}" placeholder="описание" class="inline_value js_extend_textarea js_inline_ajax_value" >{{$product->info}}</textarea>
                        {{--                        <span style="font-size: 90%;"  title="фабричное название">{{$product->fabric_name}}</span> <br>--}}
{{--                        <i style="font-size: 90%;">{{$product->artikul}}</i><br>--}}

                @forelse ($product->categories as $cat)
                <span title="{{$cat->parent->category ?? ''}}" class="js_cat_label products_category_label" data-category_id="{{$cat->id}}" data-product_id="{{$product->id}}">
                       {{mb_strtoupper(mb_substr(($cat->parent->category ?? ''),0,4))}}: {{$cat->category}}
                </span>

    @empty
                    <span class="products_category_label__nocat">нет раздела</span>
                @endforelse


@if($product->parent_collections->count()>0)
                            <br>  <span style="text-transform:uppercase;font-size: 70%;">в коллекциях</span>
                        @foreach($product->parent_collections as $collection)
    {{$collection->name}};
                        @endforeach
@endif
                    @if($product->children->count()>0) <br> <span style="cursor: pointer;border-bottom: 1px dashed grey;user-select: none;"
                                                                  onclick="$('.children{{$product->id}}').toggle('fast');$('.js_parent{{$product->id}}').toggleClass('products_table_family')">+{{$product->children->count()}} мод</span>  @endif
                    </td>








                    <td> @if($product->price<>$product->public_price)
                            {{$product->public_price}} @endif
                        <input type="text" value="{{$product->price}}"  class="inline_value js_inline_ajax_value" data-field="price"  data-product_id="{{$product->id}}">

                        {!! Form::select('',$statuses,$product->status_id,['class'=>'js_inline_ajax_value','data-field'=>'status_id','data-product_id'=>$product->id ]) !!}


                    </td>


<td>
    <input type="text" placeholder="Ширина" value="{{$product->width}}"  class="inline_value js_inline_ajax_value" data-field="width"  data-product_id="{{$product->id}}">
    <input type="text" placeholder="Высота"  value="{{$product->height}}"  class="inline_value js_inline_ajax_value" data-field="height"  data-product_id="{{$product->id}}">
    <input type="text" placeholder="Глубина"  value="{{$product->depth}}"  class="inline_value js_inline_ajax_value" data-field="depth"  data-product_id="{{$product->id}}">

</td>



                    <td class="js_click_toggle">
                      @if($product->color_id)
                        @if($product->color->photo)
                            <img src='/{{$product->color->photo}}' style='width:50px;'>
                        @elseif($product->color->hex)
                            <div style="width: 60px;height: 20px;background-color: {{$product->color->hex}}"></div>
                        @endif  <br> {{$product->color->color ?? ''}}
                    @endif
                        {{$product->factory->factory ?? ''}}</td>






                    <td>
                        {{$product->material_body->material ?? ''}}  ; {{$product->material_face->material ?? ''}}

                        <input type="text" list="colors_suggest" value="{{$product->color_body}}" placeholder="цвет корпуса" class="inline_value js_inline_ajax_value" data-field="color_body"  data-product_id="{{$product->id}}">
                        <br>
                        <input type="text" list="colors_suggest" value="{{$product->color_face}}" placeholder="цвет фасада"  class="inline_value js_inline_ajax_value" data-field="color_face"  data-product_id="{{$product->id}}">



                    </td>
                    <td>
                        @isset($product->photos[0])
                            <img onclick="$(this).toggleClass('products_listing_img_popup')" class="products_listing_img" src="/upload/{{ $product->photos[0]}}" >
                        @endisset
                    </td>


                    <td>
{{--                      $product->status->status ?? '' --}}
                        <a target="_blank" href="{{route('adm.products.copy',['product_id'=>$product->id])}}" class="ui tiny  horizontal label" title="создать копию этого товара" xxxstyle="background-color: #dadff7;">копировать</a>
                        <a target="_blank" href="{{route('adm.products.mod',['product_id'=>$product->id])}}" class="ui tiny  horizontal label" title="создать модификацию (дочерний товар)">&rdsh; мод</a>
                        <br>
                        <br>
                        <label>
                            <input class="js_checkbox" type="checkbox" value="{{$product->id}}" name="selected[{{$product->id}}]">
                            <span style="font-size: 90%;color: grey" title="дата добавления">{{$product->created_at->format('d/m')}}</span>
                        </label>
                        <a href="/mebel/{{$product->id}}" target="_blank" title="посмотреть на сайте" style="float: right;">
                            <i class="share square outline grey small icon"></i></a>
                    </td>
                </tr>



                @if($product->children->count() >0)
                    <div>
                    @foreach ($product->children
 as $child)
                        <tr class="products_table_family children children{{$product->id}}">
                            <td class="products_table_family family{{$last_num}}  family_border{{$last_num}}">&rdsh;
                                <i>{{$child->artikul}}</i>
                                <a target="_blank" href="{{route('adm.products.edit',['product'=>$child->id])}}">{{$child->name}}</a> <br>
                                <input type="text" value="{{$child->fabric_name}}" class="js_inline_ajax_value" data-field="fabric_name" data-product_id="{{$child->id}}" placeholder="фабричное название" style="font-size: 90%;padding: 2px;margin-bottom: 3px;">
                                <input type="text" value="{{$child->artikul}}"  class="js_inline_ajax_value" data-field="artikul" data-product_id="{{$child->id}}" placeholder="артикул" style="font-size: 90%;padding: 2px;margin-bottom: 3px;">
                                <textarea cols="30" rows="1" data-field="info" data-product_id="{{$child->id}}" placeholder="описание" class="inline_value js_inline_ajax_value" >{{$child->info}}</textarea>


                            @forelse ($child->categories as $cat)
                                    <span title="{{$cat->parent->category ?? ''}}" class="js_cat_label products_category_label" data-category_id="{{$cat->id}}" data-product_id="{{$child->id}}">
                       {{mb_strtoupper(mb_substr(($cat->parent->category ?? ''),0,4))}}: {{$cat->category}}
                </span>
                                @empty
                                    <span class="products_category_label products_category_label__nocat">нет раздела</span>
                                @endforelse

{{--                                @if($child->collection_id>0) <br> <span style="text-transform:uppercase;font-size: 70%;">входит в</span> {{$child->parent_collection->name}} @endif--}}

                            </td>
                            <td>   @if($child->price<>$child->public_price)
                                    {{$child->public_price}} @endif
                                <input type="text" value="{{$child->price}}"  class="inline_value js_inline_ajax_value" data-field="price"  data-product_id="{{$child->id}}">

                                {!! Form::select('',$child,$product->status_id,['class'=>'js_inline_ajax_value','data-field'=>'status_id','data-product_id'=>$child->id ]) !!}


                            </td>


                            <td>
                                <input type="text" placeholder="Ширина" value="{{$child->width}}"  class="inline_value js_inline_ajax_value" data-field="width"  data-product_id="{{$product->id}}">
                                <input type="text" placeholder="Высота"  value="{{$child->height}}"  class="inline_value js_inline_ajax_value" data-field="height"  data-product_id="{{$product->id}}">
                                <input type="text" placeholder="Глубина"  value="{{$child->depth}}"  class="inline_value js_inline_ajax_value" data-field="depth"  data-product_id="{{$product->id}}">

                            </td>




                            <td class="js_click_toggle">
                                @if($child->color_id)
                                    @if($child->color->photo)
                                        <img src='/{{$child->color->photo}}' style='width:50px;'>
                                    @elseif($child->color->hex)
                                        <div style="width: 60px;height: 20px;background-color: {{$child->color->hex}}"></div>
                                    @endif  <br> {{$child->color->color ?? ''}}
                                @endif
                                {{$child->factory->factory ?? ''}}
                            </td>
                            <td style="font-size: 85%;">
{{--                               {{$child->color_face}}  {{$child->material_face->material ?? ''}}<br>--}}
{{--                                {{$child->material_body->material ?? ''}}  {{$child->color_body}}--}}

                                {{$child->material_body->material ?? ''}}  ; {{$child->material_face->material ?? ''}}

                                <input type="text" list="colors_suggest" value="{{$child->color_body}}" placeholder="цвет корпуса" class="inline_value js_inline_ajax_value" data-field="color_body"  data-product_id="{{$child->id}}">
                                <br>
                                <input type="text" list="colors_suggest" value="{{$child->color_face}}" placeholder="цвет фасада"  class="inline_value js_inline_ajax_value" data-field="color_face"  data-product_id="{{$child->id}}">


                            </td>
                            <td>
                                @isset($child->photos[0]) <img  onclick="$(this).toggleClass('products_listing_img_popup')" class="products_listing_img" src="/upload/{{ $child->photos[0]}}"> @endisset
                            </td>
                            <td>
                                <label>
{{--                                    {{$child->status->status ?? ''}} <br>--}}

                                    <input  class="js_checkbox"  type="checkbox" value="{{$child->id}}" name="selected[{{$child->id}}]">
                                    <span style="font-size: 90%;color: grey" title="дата добавления">{{$child->created_at->format('d/m')}}</span>
                                </label>

                            </td>
                        </tr>
                    @endforeach
                    </div>
                @endif

            @endforeach
        </table>
 <br>
        @include('adm._selected')

        {{ $products->withQueryString()->links('vendor/pagination/semantic-ui') }} <br>
        <span style="font-size: 90%;">Показано: {{$products->count()}}, всего: {{$products->total()}}</span>
        <br><br><br>  <br><br><br>
    </div>




 @include('adm._products_cattree')

</div>
</form>
{{--{{ddd($cat_tree)}}}--}}
@endsection
