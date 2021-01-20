<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

<title>Мебель61</title>

{{--    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>--}}
    <script src="/css/jquery.min.js"></script>

{{--OFFLINE | ONLINE --}}
{{--    <link rel="stylesheet" href="/css/semantic.min.css" />--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.6/semantic.min.css" integrity="sha512-iSqS4kzNsM1EfZCUXG3mUIbdTLwJbH/axMoyliD6Ko5bShJbzbXVIgyK5FJqFnPiDsfw7ZLVUhx9nlGGcIeFTg==" crossorigin="anonymous" />

    <script src="/css/semantic.min.js"></script>
    <script src="/css/vue.js"></script>
    <script src="/css/Sortable.min.js" integrity="sha256-9D6DlNlpDfh0C8buQ6NXxrOdLo/wqFUwEB1s70obwfE=" crossorigin="anonymous"></script>
    <script src="/css/vuedraggable.umd.min.js"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.3.0/jscolor.min.js"></script>--}}
    {{--        <script src="/js/jquery.magnific-popup.min.js"></script>--}}
{{--        <link rel="stylesheet" href="/css/magnific-popup.min.css">--}}


    <script src="/js/adm.js?{{date('H')}}"></script>
    <link rel="stylesheet" href="/css/adm.css?{{date('H')}}">

</head>
<body style="background-color: #f8f9f5;">
<div style="width:100%;max-width: 1800px;margin: auto;padding: 10px;0">
<div id="top_nav" class="ui secondary stackable menu">
{{--    <span class="item">--}}
{{--        <object style="width: 50px;" type="image/svg+xml" data="/css/logo1.svg"></object>--}}
{{--Мебель61--}}
{{--    </span>--}}

{{--    <a href="{{route('adm.products.tree')}}" class="@php if(Route::currentRouteName()=='products_tree') echo 'active' @endphp item" id="menu-firms">--}}
{{--        <i class="cat green icon"></i>Каталог</a>--}}

    <a href="{{route('adm.products.index')}}"

       class="item" id="menu-firms" style="background-color: #fff;padding: 4px 15px;">
        <img src="/gfx/logo.png" style="margin-right: 5px;">
        Каталог товаров</a>



    <div class="right item">
        <a target="_blank" href="/" class="item"><i class="share square outline blue icon"></i>Сайт</a>
        <a href="/adm/orders" class="item"><i class="piggy bank grey icon"></i>Заказы</a>
        <a href="/adm/factories" class="item"><i class="warehouse grey icon"></i>Фабрики</a>


        <div class="item">
            <div class="ui small icon dropdown">
                <i class="cog grey icon"></i>Справочники
                <div class="menu">
                    <a href="/adm/categories" class="item">Разделы</a>
                    <a href="/adm/materials" class="item">Материалы</a>
                    <a href="/adm/colors" class="item">Цвета</a>
                    <a href="/adm/texts" class="item">Тексты</a>
                    {{--                <a href="/adm/stat" class="item">Статистика</a>--}}
                    <a href="/adm/types" class="item">Аттрибуты</a>

                </div>
            </div>
        </div>

        <div class="item">
            <div class="ui small icon dropdown">
                <i class="certificate grey icon"></i>Админ
                <div class="menu">
                    <a href="/adm/kvalues" class="item">Настройки</a>
                    <a href="/adm/banners" class="item">Баннеры</a>
                    <a href="/adm/searches" class="item">Лог поиска</a>
                    <a href="/adm/errors" class="item">Лог ошибок</a>
                </div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST"
              xstyle="display: none;">
            {{ csrf_field() }}
            <button style="padding:5px 12px;margin: 0;" class="item" type="submit">выйти</button>
        </form>
</div></div>
    @include('adm._flash_message')
        @yield('content')


    <div style="font-size: 70%;color:#ccc;float:right;">{{round(microtime(true)-LARAVEL_START,2)}}</div>

{{--    <pre>    {{ print_r(DB::getQueryLog()) }} </pre>--}}

</div>
</body>
</html>
