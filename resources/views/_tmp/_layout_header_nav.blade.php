<header class="my_container">
    <nav id="top_nav" class="navbar">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <img src="/gfx/logo_name2.png" class="logo_img">
            </a>

            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <div class="navbar-item">
                    <div class="is-hidden-desktop" style="display: inline-block;font-size: 90%;line-height: 170%;">
                        <span style="font-size: 90%">c 10.00 до 20.00</span> <br>
                        <a style="color: #1c1c1c;"  href="tel:+7(919)887-86-85">7 (919) 887-86-85</a> <br>
                        <a href="https://wa.me/79198878685"><img src="/gfx/icon_whatsapp.png"> начать чат</a> <br><br>

                        <a style="color: #1c1c1c;" href="tel:+7(919)886-85-84">7 (919) 886-85-84</a> <br>
                        <a href="https://wa.me/79198868584"><img src="/gfx/icon_whatsapp.png"> начать чат</a>
                    </div>
                </div>

            </div>

            <div class="navbar-end">
                <a class="navbar-item" href="/text/7" >О нас</a>
                <a class="navbar-item" href="/text/6" >Как заказать</a>
                <a class="navbar-item" href="/text/5" >Оплата</a>
                <a class="navbar-item" href="/text/4" >Доставка</a>
                <a class="navbar-item" href="/text/3" >Сборка</a>
                <a class="navbar-item" href="/text/1" >Гарантия и возврат</a>
                <a class="navbar-item" href="/text/2" >Контакты</a>
                <div class="navbar-item">


                </div>
            </div>
        </div>

    </nav>

    <div class="container_padding_side" id="subnav_row" style="height: 45px;background-color: #f8f8f8;padding-bottom: 10px;padding-top: 10px;">
        {{--<div style="float: left">@if(!Request::is('/'))--}}
        {{--<span style="background-color: #da4302;color:white; margin-right:0.8em;" class="button is-small is-link" onclick="$('#catalog_menu').slideToggle('fast')">Каталог</span>--}}
        {{--@endif</div>--}}
        <div style="float: left;" class="nav_search">
            <form  class="nav_search_form" action="/search">

                        <input placeholder="поиск товаров..." value="{{Request()->search_str ?? ''}}" class="input is-small" type="search" name="search_str" style="width: 78%;">
                <button type="submit" class="is-small  is-success button">
                    <img width="20" src="/gfx/icons8-search-50.png"/>

                    <span class="is-hidden-touch">Поиск</span>
                </button>
            </form>


        </div>
        <div class="is-hidden-touch" style="display: inline-block;margin-left:10px">

            <div style="font-size: 90%;line-height: 100%;">
                <a  style="color: #1c1c1c;" href="tel:+7(919)887-86-85">7
                    (919) 887-86-85</a>
{{--                <a href="https://wa.me/79198878685"> <img src="/gfx/icon_whatsapp.png" alt=""> начать чат</a>--}}
                <br>
                <a  style="color: #1c1c1c;" href="tel:+7(919)886-85-84">7 (919) 886-85-84</a>
{{--                <a href="https://wa.me/79198868584"><img--}}
{{--                        src="/gfx/icon_whatsapp.png" alt=""> начать чат</a>--}}

            </div>
        </div>

        {{--<div >--}}
        <a style="float: right;" href="/cart" class="button is-small is-info">
            <img width="20" src="https://img.icons8.com/pastel-glyph/64/FFFFFF/shopping-cart--v2.png"/>
            <span class="is-hidden-mobile">Корзина</span>
            @if(session('cart.items')) <span class="cart__count">({{count(session('cart.items'))}})</span> @endif

        </a>
        {{--</div>--}}


    </div>

    <div  class="container_padding_side header_subnav">
        @if(!Request::is('/'))
            <span style="background-color: #da4302;color:white; margin-right:0.8em;" class="button is-small is-link" onclick="$('#catalog_menu').slideToggle('fast')">Каталог</span>
        @endif
        @foreach($main_categories as $cat)
            <a href="/main/{{$cat->id}}"  class="nav_main_cat">{{$cat->shortname}}</a>
        @endforeach
    </div>
</header>
