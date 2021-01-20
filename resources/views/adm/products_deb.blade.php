@extends('adm.__layout')
@section('content')
@include('adm._products_search')

<div style="display: flex">
    <div  style="width: 80%">
        <table id="products_table" class="ui very  compact small table" style="">
            <thead>
            <tr>
                <th style="width: 30em;">Товар, артикул</th>
                <th>Цена</th>
                <th>Цвет, Фабрика</th>
                <th>Цвет <br>Корпус / Фасад</th>
                <th>Фото</th>
                <th>Дата создания, статус <br>
                <span onclick="select_all()" style="border-bottom: 1px dashed gray;cursor:pointer;">выбрать все</span></th>
            </tr>
            </thead>
            @foreach ($products as $product)
                @php
                    $last_num = substr($product->id, -1);
                    $pre_last_num = substr($product->id, -2,1);

                @endphp

                <tr class="js_parent{{$product->id}}">
                    <td @if($product->children->count()>0) class="products_table_family family{{$last_num}} family_border{{$pre_last_num}}" @endif>
                        <a class="@if($product->collection_id===0) collection_main_item @endif" target="_blank" href="/adm/products/{{$product->id}}/edit">
                            {{$product->name}}</a>
                        @if($product->collection_id===0)  <span style="text-transform:uppercase;font-size: 70%;">коллекция</span> @endif <br>
                        <i style="font-size: 90%;">{{$product->artikul}}</i><br>

                @forelse ($product->categories as $cat)
                <span class="js_cat_label products_category_label" data-category_id="{{$cat->id}}" data-product_id="{{$product->id}}">
                        {{$cat->category}}</span>
                @empty
                    <span class="products_category_label__nocat">нет раздела</span>
                @endforelse

                        @if($product->collection_id>0) <br> <span style="text-transform:uppercase;font-size: 70%;">входит в</span> {{$product->parent_collection->name}} @endif
                    @if($product->children->count()>0) <br> <span style="cursor: pointer;border-bottom: 1px dashed grey;user-select: none;"
                                                                  onclick="$('.children{{$product->id}}').toggle('fast');$('.js_parent{{$product->id}}').toggleClass('products_table_family')">+{{$product->children->count()}} мод</span>  @endif
                    </td>
                    <td class="js_click_toggle">{{$product->price}}</td>
                    <td class="js_click_toggle">
                      @if($product->color_id)
                        @if($product->color->photo)
                            <img src='/{{$product->color->photo}}' style='width:50px;'>
                        @elseif($product->color->hex)
                            <div style="width: 60px;height: 20px;background-color: {{$product->color->hex}}"></div>
                        @endif  <br>
                    @endif
                        {{$product->factory->factory ?? ''}}</td>

                    <td  class="js_click_toggle" style="font-size: 85%;"> {{$product->color->color ?? ''}} <br>
                        {{$product->color_body}} / {{$product->color_face}}<br>
                        {{$product->material_body->material ?? ''}} / {{$product->material_face->material ?? ''}}
                    </td>
                    <td>
                        @isset($product->photos[0])
                            <img onclick="$(this).toggleClass('products_listing_img_popup')" class="products_listing_img" src="/upload/{{ $product->photos[0]}}" >
                        @endisset
                    </td>
                    <td>
                        {{$product->status->status ?? ''}}   <a target="_blank" href="{{route('adm.products.copy',['product_id'=>$product->id])}}" class="ui tiny  horizontal label" title="создать копию этого товара" xxxstyle="background-color: #dadff7;">копировать</a>
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
                    @foreach ($product->children as $child)
                        <tr class="products_table_family children children{{$product->id}}">
                            <td class="products_table_family family{{$last_num}}  family_border{{$pre_last_num}}">&rdsh;
                                <i>{{$child->artikul}}</i>
                                <a target="_blank" href="{{route('adm.products.edit',['product'=>$child->id])}}">{{$child->name}}</a> <br>
{{--                                @foreach($child->categories as $cat) <span class="products_category_label">{{$cat->category}}</span> @endforeach--}}

                                @forelse ($child->categories as $cat)
                                    <span class="products_category_label">{{$cat->category}}</span>
                                @empty
                                    <span class="products_category_label products_category_label__nocat">нет раздела</span>
                                @endforelse

                                @if($child->collection_id>0) <br> <span style="text-transform:uppercase;font-size: 70%;">входит в</span> {{$child->parent_collection->name}} @endif

                            </td>
                            <td class="js_click_toggle" >{{$child->price}}</td>
                            <td class="js_click_toggle" >
                                @if($child->color_id)
                                    @if($child->color->photo)
                                        <img src='/{{$child->color->photo}}' style='width:50px;'>
                                    @elseif($child->color->hex)
                                        <div style="width: 60px;height: 20px;background-color: {{$child->color->hex}}"></div>
                                    @endif  <br>
                                @endif
                                {{$child->factory->factory ?? ''}}
                            </td>
                            <td  class="js_click_toggle"  style="font-size: 85%;"> {{$product->color->color ?? ''}} <br>
                                {{$child->color_body}} / {{$child->color_face}}<br>
                                {{$child->material_body->material ?? ''}} / {{$child->material_face->material ?? ''}}
                            </td>
                            <td>
                                @isset($child->photos[0]) <img  onclick="$(this).toggleClass('products_listing_img_popup')" class="products_listing_img" src="/upload/{{ $child->photos[0]}}"> @endisset
                            </td>
                            <td>
                                <label>{{$child->status->status}} <br>

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




    <div style="width: 250px;margin-left: 10px;">
        <ul style="font-size: 100%;line-height: 110%;margin: 0;list-style-type: none;padding: 0">
            @foreach ($cat_tree as $cat)
                <li style="margin-left: 0;padding-left: 0;">
                   <br><span style="font-weight: 300;">{{ $cat->category }}</span>
                    <ul style="margin-left: 0;list-style-type: none;padding-left: 0">
                        @foreach ($cat->subcat->where('subparent_id',0) as $scat)
                            <li>
                        <a href="/adm/products?category_id={{$scat->id}}"
                           @if (isset($_GET['category_id']) AND $_GET['category_id']==$scat->id) style='font-weight:500;border-bottom: 1px solid grey' @endif
                        >{{ $scat->category }}</a>
                                <span style="font-size: 80%;">{{ $scat->products->count() }}</span>
                                <ul style="margin-left: 0;list-style-type: none;padding-left: 0;">

                                @foreach ($scat->subchildren as $sscat)
                                        <li>↳
<a href="/adm/products?category_id={{$sscat->id}}"
   @if (isset($_GET['category_id']) AND $_GET['category_id']==$sscat->id) style='font-weight:500;border-bottom: 1px solid grey' @endif
>
    {{ $sscat->category }}
</a>
{{--                                            <span style="font-size: 80%;">{{ $sscat->products->count() }}</span>--}}

                                    @endforeach

                                </ul>

                        @endforeach
                    </ul>
            @endforeach
        </ul>
    </div>

</div>
</form>
{{--{{ddd($cat_tree)}}}--}}
@endsection
