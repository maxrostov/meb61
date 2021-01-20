<!DOCTYPE html>
<html>
@include('_layout_head')
<body>
 @include('_layout_header_nav')







<main class="my_container" style="background-color: #fff;">
    @includeWhen(!Request::is('/'), '_menu', ['css_inline' => 'display:none;'])
        @yield('before_body')

    <div class="container_padding_side">

        @if(Session::has('flash_message'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                {{ Session::get('flash_message') }}
            </div>
        @endif

        @yield('body')
    </div>
</main>


@include('_layout_footer')

</body>
{{--<script src="{{ mix('js/app.js') }}"></script>--}}
</html>
