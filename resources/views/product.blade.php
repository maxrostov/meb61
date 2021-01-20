@extends('__layout')
@section('body')
    <style>
        .swiper-container{
            width: 100%;
        }
    </style>

@include('_product_breadcrumbs')
    @include('_vue_and_slider')

    <h1 class="is-size-2 is-size-4-mobile">{{$product->name}}</h1>


        <div  class="columns">
            <div class="column" style="min-width:0;">
              @isset($product->photos)
                @if(count($product->photos)>1)

                    <!-- Slider main container -->
                        <div class="swiper-container">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                    @foreach($product->photos as $photo)
                                        <div class="swiper-slide"><img class="product_img" src="/upload/{{$photo}}"></div>
                                    @endforeach
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                        </div>
@else
                        <img class="product_img" src="/upload/{{$product->photos[0]}}">
                 @endif
                  @else
                      <img class="product_img" src="/gfx/no-photo.jpg" style="opacity:0.2">
                  @endisset
            </div>
            <div class="column">
                <span class="product_price">
                     @if($product->categories->find(442))
                        Под заказ
                    @elseif($product->public_price)
                        {{$product->public_price}}<span class="product_price_rub">₽</span>
                    @else
                        <span class="product_zero_price">цена обновляется</span>
                    @endif

                </span>


                <br>

                @if($is_in_cart)
                 <div class="is_in_cart" style="padding: 5px;border: 1px solid #64a849; display: inline-block">Товар уже в <a href="/cart">корзине</a></div>
            @else
                    <form action="" method="POST">
                        @csrf
                        <button type="submit" class="button is-success">Купить</button>
                    </form>
                    @endif




            @if($product->children->count())
                     <b>Модификации</b>   <br>
                 @endif




<table style="font-size: 90%;" class="table is-striped is-narrow is-hoverable is-fullwidth">
    @foreach($product->tvalues as $value)
        <tr>
            <td>{{$value->type->type}}</td>
            <td>{{$value->value}}</td>
        </tr>

        @endforeach
<tr><td>Фабрика</td><td>{{$product->factory->factory ?? '-'}}</td></tr>
<tr><td>Ширина</td><td>{{$product->width ?? '-'}}</td></tr>
<tr><td>Высота</td><td>{{$product->height ?? '-'}}</td></tr>
<tr><td>Глубина</td><td>{{$product->depth ?? '-'}}</td></tr>

<tr><td>Корпус</td><td>{{$product->material_body->material ?? '-'}} {{$product->color_body}}</td></tr>
<tr><td>Фасад</td><td>{{$product->material_face->material ?? '-'}} {{$product->color_face}}</td></tr>

<tr><td>Вес, кг</td><td>{{$product->weight ?? '-'}}</td></tr>
<tr><td>Объем, м<sup>3</sup></td><td>{{$product->volume ?? '-'}}</td></tr>
<tr><td>Упаковок, шт</td><td>{{$product->load ?? '-'}}</td></tr>

</table>


            </div>
        </div>
        <div class="columns">
            <div class="column"> <div class="content" style="white-space:pre-line">
                   {{$product->info}}

{{--                    {{str_replace("\n\n","\n",str_replace("\r",'',$product->info))}}--}}
                </div>
            </div>
{{--            <div class="column">   </div>--}}
        </div>


{{--    @if($product->collection_id===0)--}}
{{--            <b>Модули</b>   <br>--}}
{{--            <div style="--}}
{{--	display: flex;--}}
{{--	flex-direction: row;--}}
{{--	flex-wrap: wrap;--}}
{{--	justify-content: flex-start;--}}
{{--	align-items: stretch;--}}
{{--	align-content: stretch;--}}
{{--">--}}
{{--            @forelse ($product->children_collection as $module)--}}
{{--                @include('front._item',['product'=>$module])--}}

{{--                <br>--}}
{{--            @empty--}}
{{--            @endforelse--}}
{{--            </div>--}}

{{--        @endif--}}

        <script>
            var mySwiper = new Swiper('.swiper-container', {
                // Optional parameters
                // direction: 'vertical',
                loop: true,
                grabCursor:true,
                // setWrapperSize:true,

                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },


            })

        </script>

@endsection
