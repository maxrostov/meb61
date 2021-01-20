Vue.use(VueAwesomeSwiper);
new Vue({
    el: '#vueapp',
    // components: {
    //     LocalSwiper: VueAwesomeSwiper.swiper,
    //     LocalSlide: VueAwesomeSwiper.swiperSlide,
    // },
    data: {

        active_mod_id:null,
        family: @json($family_json),
        category:@json($category),
        is_in_cart:@json($is_in_cart),
        types:@json($types),
        photos:[],
        swiperOptions: {
            grabCursor:true,
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        },

    },
    watch:{
        active_mod_id: function () {
            // когда у всех модов одинаковая картинка,
            // то слайдер не выводим, и соответственно переключать не нужно
            if(this.photos.length > 1) {
                photo = this.family[this.active_mod_id].photos[0]; // первое фото активного товара
                index = this.photos.indexOf(photo); // ищем индекс в общем списке (из списка удалены возможные дубликаты)
                this.swiper.slideTo(index);
            }
        }
    },
    computed: {
        product: function(){

            return  this.family[this.active_mod_id];
        },


    },
    methods:{
        // один массив из всех фотографий всех модификаций, для сладера
        combine_all_mod_photos: function(){
            var arr = [];
            // let first_photos  = {}; // первое фото каждого товара сохраняем с id,
            // чтобы при выборе прокручивать слайдер на него.

            for (var key in this.family) {
                arr = arr.concat(this.family[key].photos);
            }
            //
            var uniq_photos = arr.reduce(function(a,b){
                if (a.indexOf(b) < 0 ) a.push(b);
                return a;
            },[]);

            return uniq_photos;
        }
    },


    created: function(){
        a = 1;
        this.active_mod_id = Object.keys(this.family)[0];
        this.product = this.family[this.active_id];
        this.photos = this.combine_all_mod_photos();


    }
});
