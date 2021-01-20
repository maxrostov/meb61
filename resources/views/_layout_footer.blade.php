<div class="my_container container_padding_side" style="margin-top: 3px;background-color:#f8f8f8;width: 100%;">
    <div class="columns">
        <div class="column">
            <img class="is-hidden-mobile" src="/gfx/logo.png" style="height: 80px;">
            <br>
        </div>
        <div class="column">
            <a href="/text/7" style="margin-right: 15px;padding-top: 14px; ">О нас</a>
            <a href="/text/6" style="margin-right: 15px;padding-top: 14px; ">Как заказать</a>
            <a href="/text/5" style="margin-right: 15px;padding-top: 14px; ">Оплата</a>
            <a href="/text/4" style="margin-right: 15px;padding-top: 14px; ">Доставка</a>
            <a href="/text/1" style="padding-top: 14px; ">Гарантия и возврат</a>
            <a href="/text/3" style="margin-right: 15px;padding-top: 14px; ">Сборка</a>
            <a href="/text/2" style="margin-right: 15px;padding-top: 14px; ">Контакты</a>

        </div>
        <div class="column">
 {!!  $footer_middle->text !!}
        </div>


        <div class="column">

            @php
            // скрытая ссылка для быстрого перехода в админку
            if (Route::currentRouteName()=='product') {
            $url = "/adm/products/".request()->product_id."/edit";
            } else{
            $url = "/login";
            }
            @endphp

            <noindex><a rel="nofollow" data-no-instant href="{{$url}}" style="color:#4a4a4a;">Россия</a>,</noindex>
            {!! $footer_right->text !!}
        </div>
    </div>
    <a href="/text/8" style="font-size: 80%;">Политика в отношении обработки персональных данных</a>

</div>

