
<script data-no-instant>
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


<script data-no-instant>

    // https://github.com/RobinHerbots/Inputmask
    var selector = document.getElementById("phone_mask");
    console.log(selector)
    var im = new Inputmask("[+9](999) 999-99-99");
    im.mask(selector);



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


<script async data-no-instant>
    (function(w,d,u){
        var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
    })(window,document,'https://cdn-ru.bitrix24.ru/b13820096/crm/site_button/loader_2_kbd2zc.js');
</script>



<!-- Yandex.Metrika counter -->
<script async type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter67108063 = new Ya.Metrika({
                    id:67108063,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/67108063" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
