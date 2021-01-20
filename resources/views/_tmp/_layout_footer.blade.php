<div class="my_container container_padding_side" style="margin-top: 3px;background-color:#f8f8f8;width: 100%;">
    <div class="columns">
        <div class="column">
            <img src="/gfx/logo.png" style="height: 80px;">
            <br>
        </div>
        <div class="column">
            <a href="/text/7"  style="margin-right: 15px;padding-top: 14px; ">О нас</a>
            <a href="/text/6"  style="margin-right: 15px;padding-top: 14px; ">Как заказать</a>
            <a href="/text/5"  style="margin-right: 15px;padding-top: 14px; ">Оплата</a>
            <a href="/text/4"  style="margin-right: 15px;padding-top: 14px; ">Доставка</a>
            <a href="/text/1"  style="padding-top: 14px; ">Гарантия и возврат</a>
            <a href="/text/3"  style="margin-right: 15px;padding-top: 14px; ">Сборка</a>
            <a href="/text/2"  style="margin-right: 15px;padding-top: 14px; ">Контакты</a>


        </div>
        <div class="column">
            <a  style="color: #1c1c1c;" href="tel:+7(919)887-86-85">7
                (919) 887-86-85</a><a href="https://wa.me/79198878685"> <img
                    src="/gfx/icon_whatsapp.png" alt=""> начать чат</a>
            <br>
            <a  style="color: #1c1c1c;" href="tel:+7(919)886-85-84">7 (919) 886-85-84</a>
            <a href="https://wa.me/79198868584"><img
                    src="/gfx/icon_whatsapp.png" alt=""> начать чат</a> <br>
            <span style="font-size: 90%">c 10.00 до 20.00</span>       </div>


        <div class="column">
            <a href="/login" style="color:#4a4a4a;">Россия</a>, г. Ростов-на-Дону,  <br> ул. Нансена 99
        </div>
    </div>
    <a href="/text/8" style="font-size: 80%;">Политика в отношении обработки персональных данных</a>

</div>


<script>
    WebFontConfig = {
        google: {
            families: ['Oswald']
        }
    };

    (function(d) {
        var wf = d.createElement('script'), s = d.scripts[0];
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
        wf.async = true;
        s.parentNode.insertBefore(wf, s);
    })(document);
</script>


<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    // Check for click events on the navbar burger icon
    $(".navbar-burger").click(function() {

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");

    });
    // https://bulma.io/documentation/elements/notification/
    // close session notification banner
    (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
        $notification = $delete.parentNode;
        $delete.addEventListener('click', () => {
            $notification.parentNode.removeChild($notification);
        });
    });


</script>

<script src="/js/instantclick.min.js" data-no-instant></script>
<script data-no-instant>InstantClick.init();</script>


<script>
    (function(w,d,u){
        var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
    })(window,document,'https://cdn-ru.bitrix24.ru/b13820096/crm/site_button/loader_2_kbd2zc.js');
</script>


<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(67108063, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/67108063" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
