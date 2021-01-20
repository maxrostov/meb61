<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Интернет-магазин «Мебель61» предлагает мебель и товары для дома по лучшим ценам напрямую с фабрики!" />
    <meta name="keywords" content="ростов-на-дону, мебельный интернет-магазин, корпусная мебель, мягкая мебель, мебель для дома, мебель для дачи, офисная мебель, мебель61" />

    <link rel="apple-touch-icon" sizes="180x180" href="/gfx/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/gfx/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/gfx/favicon-16x16.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$html_title ?? 'Мебель61'}}</title>
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.0/css/bulma.min.css" integrity="sha256-aPeK/N8IHpHsvPBCf49iVKMdusfobKo2oxF8lRruWJg=" crossorigin="anonymous" />--}}
    <link rel="stylesheet" href="/css/bulma.min.css" />
    <link rel="stylesheet" href="/css/my.css?{{date('Hi')}}">

    {{--    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="/css/jquery.min.js"></script>
{{--    <script src="/js/front.js?{{date('Hi')}}"></script>--}}

{{--    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">--}}

    {{--    <link rel="stylesheet" href="https://unpkg.com/swiper@6.0.4/swiper-bundle.css">--}}
{{--            <script src="https://unpkg.com/vue@2.6.11/dist/vue.min.js?1"></script>--}}
{{--        <script src="https://vuejs.org/js/vue.js"></script>--}}
    <script src="/css/vue.js"></script>

    <!-- Swiper library -->
    <script src="/js/swiper/swiper-bundle.min.js"></script>
    <link href="/js/swiper/swiper.min.css" rel="stylesheet">
    <script src="/js/swiper/vue-awesome-swiper.js"></script>

    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />--}}
</head>
