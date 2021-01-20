@extends('__layout')
@section('body')

    @include('_product_breadcrumbs')
    @include('_vue_and_slider')
        <style>
            @media (min-width: 800px) {
                .vue_column{
                    width: 50%;
                }
.vue_column_pic{
    margin-right: 15px;
}
                .vue_columns{
                    display: flex;
                    /*flex: 1 1 0px;*/
                }
                 }

        </style>
        <form action="" method="POST">
            @csrf
        @verbatim
<div id="vueapp">
<h1 class="is-size-2  is-size-4-mobile"> {{product.name}}</h1>
<div class="columns">
<div  class="column zzz-vue_column_pic" style="min-width:0;">

<div v-if="photos.length>1"  class="swiper" v-swiper:swiper="swiperOptions">
<div class="swiper-wrapper">
<div class="swiper-slide" :key="photo" v-for="photo in photos">
<img :src="'/upload/'+photo">
</div>
</div>
<div class="swiper-pagination"  slot="pagination"></div>
<div class="swiper-button-prev" slot="button-prev"></div>
<div class="swiper-button-next" slot="button-next"></div>
</div>
<img v-else :src="'/upload/'+photos[0]">

</div>
<div class="column">
<span class="product_price">

   <template v-if="product.categories !== undefined && product.categories.findIndex(x => x.id == '442')!=-1">
     <span  class="product_zero_price">под заказ</span>
</template>
   <template  v-else-if="product.public_price">
    {{product.public_price}}<span class="product_price_rub">₽</span>
</template>

    <span v-else class="product_zero_price">цена обновляется</span>

</span> <br>


    <div  style="margin-bottom: 10px;font-size: 125%;">
        <div v-for="mod in family">
            <label :for="'mod'+mod.id" style="display: flex;cursor:pointer;user-select: none;">
                <input type="radio" name="mods" :value="mod.id" :id="'mod'+mod.id" v-model="active_mod_id">
                <template v-if="mod.color">
                    <template v-if="mod.color.photo">
                        <img :src="'/'+mod.color.photo" :title="mod.color.color"
                             style="width:50px;height:40px;margin: 5px 10px;">
                    </template>
                    <template v-else-if="mod.color.hex">
                        <div
                            :style="'border:1px solid grey;margin: 5px 10px;width:50px;height:40px;background-color:'+mod.color.hex"
                            :title="mod.color.color"></div>
                    </template>
                </template>
                <span style="margin-left: 5px;">{{mod.mod_name}} {{mod.color_body}} {{mod.color_face}} </span></label>

        </div>
    </div>


<input type="hidden" name="active_mod_id" :value="active_mod_id">
<div v-if="0" class="is_in_cart" style="padding: 5px;border: 1px solid #64a849; display: inline-block">Товар уже в <a href="/cart">корзине</a></div>
<button  xxv-else type="submit" class="button is-success">Купить</button>


<table style="width: 100%;" class="table is-striped is-narrow is-hoverable">
<template v-if="product.tvalues" v-for="tvalue in product.tvalues">
<tr><td>{{types[tvalue.type_id]}}</td><td>{{tvalue.value}}</td></tr>


</template>


                <tr v-if="product.factory"><td>Фабрика</td><td>{{  product.factory.factory || '' }}</td></tr>
                <tr><td>Ширина</td><td>{{product.width || ''}}</td></tr>
                <tr><td>Высота</td><td>{{product.height || ''}}</td></tr>
                <tr><td>Глубина</td><td>{{product.depth || ''}}</td></tr>
                <tr><td>Корпус</td><td>{{product.material_body ? product.material_body.material: ''  }} {{product.color_body || ''}}</td></tr>
                <tr><td>Фасад</td><td>{{product.material_face ? product.material_face.material: ''  }} {{product.color_face || ''}}</td></tr>
                <tr><td>Вес, кг</td><td>{{product.weight || ''}}</td></tr>
                <tr><td>Объем, м<sup>3</sup></td><td>{{product.volume || ''}}</td></tr>
                <tr><td>Упаковок, шт</td><td>{{product.load || ''}}</td></tr>
            </table>



                            </div>
                        </div>
    <br clear="all">
                        <div class="xcolumns">
                            <div class="column"> <div class="content" style="white-space:pre-line">{{product.info}}</div>
                            </div>
                        </div>


                        <br>
                    </div>
        @endverbatim
        </form>



        <script>
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

                        for ( key in this.family) {
                            arr = arr.concat(this.family[key].photos);
                        }

                        var uniq_photos = arr.reduce(function(a,b){
                            if (a.indexOf(b) < 0 ) a.push(b);
                            return a;
                        },[]);

                return uniq_photos;
                    }
                },


                created: function(){
                    this.active_mod_id = Object.keys(this.family)[0];
                    this.product = this.family[this.active_id];
                    this.photos = this.combine_all_mod_photos();


                }
            });
        </script>

@endsection
