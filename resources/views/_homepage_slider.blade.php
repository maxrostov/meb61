
<div class="swiper_homepage_hero swiper-container">
    <div class="swiper-wrapper">
        @foreach($slides as $slide)
            <div class="swiper-slide">
                @if($slide->url)
                    <a data-no-instant href="{{$slide->url}}"><img src="/sliders/{{$slide->id}}.jpg" alt=""></a>
                @else
                    <img src="/sliders/{{$slide->id}}.jpg" alt="">
                @endif
            </div>
        @endforeach
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination"></div>
</div>


{{--    <div style="--}}
{{--    display: flex;justify-content: center;align-items: center;--}}
{{--    background-size: cover;height: 400px;background-image: url(/gfx/slider1.jpg);">--}}
{{--        <div style="margin-top: 30px;text-shadow: 1px 1px 3px #000000a6;background: #09090947;padding: 1rem;"><span style="font-size: 300%;color: white;font-weight: bold;">Добро пожаловать!</span> <br>--}}
{{--        <span style="color: white;">Бесплатная доставка по <a href="/text/4" style="color: white;text-decoration: underline;">акции</a></span>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--</div>--}}
<script>
    // $(document).ready(function(){

        var mySwiper = new Swiper('.swiper_homepage_hero', {
            loop: true,
            autoplay: {
                delay: 3000,
            },
            speed: 400,
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        });

    // });
</script>
