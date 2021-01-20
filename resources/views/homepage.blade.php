@extends('__layout')
@section('before_body')
    <script src="/js/swiper/swiper-bundle.min.js"></script>
    <link href="/js/swiper/swiper.min.css" rel="stylesheet">

    @include('_homepage_slider')
    @include('_menu')
@endsection
@section('body')


<h1>Магазин "Мебель 61" &mdash; это мебель в Ростове и Ростовской области</h1>

{{--zzz_style="--}}
{{--display: flex;--}}
{{--flex-direction: row;--}}
{{--flex-wrap: wrap;--}}
{{--justify-content: flex-start;--}}
{{--align-items: stretch;--}}
{{--align-content: stretch;"--}}

@if(count($promo1_products)>1)
<h3 class="is-size-2">{{$promo1_label}}</h3>
<div class="homepage_promo1_products swiper-container">
    <div class="swiper-wrapper">
{{--            @foreach ($promo1_products as $item)--}}
            @each('_item_slider', $promo1_products, 'product')
{{--            @endforeach--}}
      </div>
    <div style="bottom: -3px;" class="swiper-pagination swiper-pagination_actions"></div>
    <div class="swiper-button-prev swiper-button-prev_actions"></div>
    <div class="swiper-button-next swiper-button-next_actions"></div>

</div>
@endif


@if(count($promo2_products)>1)
    <h3 class="is-size-2">{{$promo2_label}}</h3>
    <div class="homepage_promo2_products swiper-container">
        <div class="swiper-wrapper">
            @each('_item_slider', $promo2_products, 'product')
        </div>
        <div style="bottom: -3px;" class="swiper-pagination swiper-pagination_actions"></div>
        <div class="swiper-button-prev swiper-button-prev_actions"></div>
        <div class="swiper-button-next swiper-button-next_actions"></div>

    </div>
@endif


<br><br>
<div class="columns">
    <div class="column homepage_features"> <img src="/gfx/icons8-discount.png" alt=""><h3>Лучшие цены</h3>У нас самые выгодные цены среди конкурентов! В нашем ассортименте красивая, современная мебель для человека с любыми финансовыми возможностями.</div>
    <div class="column homepage_features"><img src="/gfx/icons8-delivery.png" alt=""><h3>Быстрая доставка</h3>  У нас собственная службы доставки, которая оперативно поставляет заказы любых объемов по любому направлению.</div>
    <div class="column homepage_features"><img src="/gfx/icons8-quality.png" alt=""><h3>Гарантия и возврат</h3>Мы занимаемся продажей исключительно качественной и надежной мебели, которая прослужит исправно и долго.</div>
    <div class="column homepage_features"><img src="/gfx/icons8-furniture.png" alt=""><h3>Большой выбор</h3>Каталог содержит более 70 000 товаров, поэтому каждый покупатель найдет все для обустройства своего жилья.</div>
</div>


<script>
    var promo1_products = new Swiper('.homepage_promo1_products', {
        loop: true,
        autoplay: {
            delay: 3000,
        },
        speed: 400,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination_actions',
        },
        autoHeight: true, //enable auto height
        navigation: {
            nextEl: '.swiper-button-next_actions',
            prevEl: '.swiper-button-prev_actions',
        },
        breakpoints: {
            400: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1000: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
        }
    });

    var promo2_products = new Swiper('.homepage_promo2_products', {
        loop: true,
        autoplay: {
            delay: 3000,
        },
        speed: 400,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination_actions',
        },
        autoHeight: true, //enable auto height
        navigation: {
            nextEl: '.swiper-button-next_actions',
            prevEl: '.swiper-button-prev_actions',
        },
        breakpoints: {
            400: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1000: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
        }
    });
</script>


@endsection
