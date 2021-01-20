<div class='item'>
    <a href="/mebel/{{$product->id}}@isset($category->id)?c={{$category->id}}@endisset" style="color: #0b0b0b">
        <h3 class="is-size-5" style="line-height: 120%;height: 4em;font-weight: 300;">{{$product->name}}</h3>
        @if($product->photos)
            <div class="card_img_wrapper"><img class="card_img" src="/upload/{{$product->photos[0]}}" alt=""></div>
    <br>
    @endif
    </a>

    <table  style="font-size: 80%;" class="table is-bordered is-narrow is-hoverable is-fullwidth">

        <tr>
            <td>Ширина</td> <td>{{$product->width}}</td>
        </tr>
        <tr>
            <td>Высота</td> <td>{{$product->height}}</td>
        </tr>
        <tr>
            <td>Глубина</td> <td>{{$product->depth}}</td>
        </tr>
        <tr>
            <td>Материал</td> <td>{{$product->material_body->material ?? ''}} {{$product->material_face->material ?? ''}} </td>
        </tr>
        <tr>
            <td>Фабрика</td> <td>{{$product->factory->factory ?? ''}}</td>
        </tr>
    </table>
    <span class="card_price">

      @if($product->is_collection)
            <span style="color:grey;font-size: 80%;font-weight: normal;">модули внутри</span>

        @elseif($product->price)
             {{$product->price}}<span class="product_price_rub">₽</span>

        @else
            <span style="font-size: 80%;font-weight: normal;">цена обновляется</span>
        @endif

    </span>
   @if($product->children->count())




        <div style="display: flex;float:right;">
            @php $flag_pics_num = 0; @endphp
            @foreach($product->children as $child)

                @if($child->color_id)
                    @php $flag_pics_num = 1; @endphp
                @if($child->color->photo)

                        <img src='/{{$child->color->photo}}' style='width: 30px;height: 30px;'
                             title="{{$child->color->color}}">
                    @elseif($child->color->hex)
                        <div style="border-left:1px solid grey;border-right:1px solid grey;width: 30px;height: 30px;background-color: {{$child->color->hex}}"
                             title="{{$child->color->color}}"></div>
                    @endif  <br>
                @endif
            @endforeach

        @if($flag_pics_num==0)
                <span class="card_mod_count" title="имеет {{$product->children->count()}} модифкации">+{{$product->children->count()}} модиф.</span>
            @endif
        </div>

       @endif

</div>
