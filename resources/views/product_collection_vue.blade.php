@extends('__layout')
@section('body')
    @include('_product_breadcrumbs')
    @include('_vue_and_slider')

        <form action="" method="POST">
            @csrf
        @verbatim
        <div id="vueapp">
            <h1 class="is-size-2  is-size-4-mobile"> {{product.name}}</h1>
                        <div class="columns">
                            <div class="column" style="min-width:0;">
                          <div style="max-width: 500px">



                              <swiper v-if="product.photos.length>1" :options="swiperOptions">
                                    <div class="swiper-slide" :key="photo" v-for="photo in product.photos">
                                        <img :src="'/upload/'+photo">
                                    </div>

                                    <div class="swiper-pagination"  slot="pagination"></div>
                                    <div class="swiper-button-prev" slot="button-prev"></div>
                                    <div class="swiper-button-next" slot="button-next"></div>
                                </swiper>
                              <img  class="product_img"  v-else :src="'/upload/'+product.photos[0]">
                          </div>
                            </div>
                <div class="column">
                    <template  v-if="sum_total">
                        <span class="product_price">{{sum_total}}<span class="product_price_rub">₽</span></span> <br>
                        <input type="hidden" name="selected_ids" :value="JSON.stringify(selected_ids)">
                        <li class='selected_collection_item' v-for="module in modules" v-if="module.selected">
                           {{module.name}}, {{module.public_price}} р.
                       </li>
                        <button type="submit" class="button is-success">Купить</button>
                        </template>
                   <template v-else>
                       <span  class="product_price" style="font-size: 120%;">выберите модули</span>
                   </template>


                    <table style="width: 100%;" class="table is-striped is-narrow is-hoverable">
                        <tr v-if="product.factory"><td>Фабрика</td><td>{{product.factory.factory || ''}}</td></tr>
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
            <div class="columns">
                <div class="column"> <div class="content" style="white-space:pre-line">{{product.info}}</div>
                </div>
            </div>


            <br>
            <b>Модули</b>   <br>
<div v-if="modules" style="
display: flex;
flex-direction: row;
flex-wrap: wrap;
justify-content: flex-start;
align-items: stretch;
align-content: stretch;
">

<div class='item' style="width: 300px;" v-for="module in modules">
<input type="checkbox" :checked="module.selected > 0" :value="module.id" :id="'module'+module.id"
       @change="checkbox_click(module)">
<label :for="'module'+module.id">выбрать</label>
    <br>
    <a :href="'/mebel/'+module.id"><h3 class="is-size-5"
           style="height: 3em;font-weight: 300;border-bottom:1px solid rgb(208, 214, 226);display: inline">{{module.name}}</h3>
    </a>





    <div class="card_img_wrapper">
    <img v-if="module.photos" class="card_img" :src="'/upload/'+module.photos[0]" alt="">
</div>
    <table  style="font-size: 80%;" class="table is-bordered is-narrow is-hoverable is-fullwidth">

    <tr>
            <td>Ширина</td> <td>{{module.width}}</td>
        </tr>
        <tr>
            <td>Высота</td> <td>{{module.height}}</td>
        </tr>
        <tr>
            <td>Глубина</td> <td>{{module.depth}}</td>
        </tr>
        <tr v-if="module.material_body">
            <td>Материал</td> <td>{{module.material_body.material || ''}}

            </td>
        </tr>
    </table>
<br>
<span class="card_price">


      <template v-if="module.public_price">
    {{module.public_price}}<span class="card_price_rub">₽</span>
</template>

    <span v-else style="color: grey;font-weight:normal;">цена обновляется</span>



</span>
    <div class="field has-addons" style="width: 6em;float: right">
        <div class="control">
            <a class="button is-info is-light is-small" @click="if(module.selected) module.selected--">-</a>
        </div>
        <div class="control">
            <input class="input is-small" v-model.number="module.selected">
        </div>
        <div class="control">
            <a class="button is-info is-light is-small"  @click="module.selected++">+</a>
        </div>
    </div>
</div>

</div>
<p v-else>модулей пока нет</p>

        </div>
        @endverbatim
        </form>

{{-- VUEJS  --}}

        <script>
            Vue.use(VueAwesomeSwiper);
            new Vue({
                el: '#vueapp',
                components: {
                    LocalSwiper: VueAwesomeSwiper.swiper,
                    LocalSlide: VueAwesomeSwiper.swiperSlide,
                },
                data: {
                    // active_id:null,
                    product: @json($product),
                    modules: @json($modules_json),
                    // collection_selected:[],
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
                computed: {

sum_total: function(){
    sum = 0;
    Object.entries(this.modules).forEach(function([key, val]) {

        sum += val.selected * val.public_price;
    });
// if(sum==0) sum = 'выберите модули';
    return sum;
},
                    selected_ids: function(){
                        selected = {};
                        Object.entries(this.modules).forEach(function([key, val])  {

                             if (val.selected)
                               {
                                 selected[key] = val.selected;
                               }
                             else // если было выбрано, но потом сняли галочку - удаляем
                                 if(selected[key] !== undefined) selected[key] = undefined;
                        });

                        return selected;
                    },
                },

                methods:{
                    checkbox_click: function(module){
                        module.selected = (module.selected ) ? 0 : 1;

                    },

                }

            })
        </script>

@endsection
