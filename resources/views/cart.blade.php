@extends('__layout')
@section('body')
@include('_vue_and_slider')


    <h1 class="is-size-1 is-size-4-mobile">Корзина</h1>




            <form id="cart_form" action="/cart" method="post">
            @csrf
                @verbatim



                    <div id="vueapp_cart">
                        <input type="hidden" :value='JSON.stringify(cart_items)' name="cart_items">

                        <table class="cart_table" style="width: 100%;border:1px solid #ccc">
                <template v-for="product in cart_products">
                    <tr  :class="{cart_item_disabled:!cart_items[product.id]}">
                        <td colspan="2">{{product.name}}</td>
                    </tr>
                  <tr :class="{cart_item_disabled:!cart_items[product.id]}">  <td style="display: inline-block">

                        <template v-if="product.photos">
                            <img :src="'/upload/'+product.photos[0]"
                                 onclick="$(this).toggleClass('cart_img_popup')"
                                 class="cart_img">
                        </template>
                    </td>
                    <td>
                        <template v-if="product.public_price">
                            {{product.public_price * cart_items[product.id]}} р.
                        </template>
                        <span v-else>по запросу</span>
                        <br clear="all">
                        <div class="field has-addons" style="width: 6em;">


                                <div class="control">
                                    <a class="button is-info is-light is-small"
                                       @click="cart_items[product.id]--" v-if="cart_items[product.id]>0">-</a>
                                </div>

                                <div class="control">
                                    <input :name="'items['+product.id+']'" class="input is-small" min="0" max="100"
                                           v-model.number="cart_items[product.id]">
                                </div>
                                <div class="control">
                                    <a class="button is-info is-light is-small" @click="cart_items[product.id]++">+</a>
                                </div>

                        </div>
                        <span class="cart_delete_item_button" v-if="cart_items[product.id]>0" @click="delete_item(product.id)">удалить</span>

                    </td>
                </tr>
                </template>
                <tfoot>
                <tr>
                    <td class="cart_sum_total">Итого</td>

                    <td class="cart_sum_total">{{sum_total}}<span class="product_price_rub">₽</span></td>
                </tr>
                </tfoot>
            </table>




                    <div class="field is-horizontal" style="margin-top: 15px;">
                        <div class="field-body">
                            <div class="control">
        <label class="radio">
            <input  value="pickup" type="radio" name="delivery"  checked>
            Самовывоз
        </label>
        <label class="radio">
            <input  value="our_delivery" type="radio" name="delivery">
            Доставка по Ростову-на-Дону
        </label>
        <label class="radio">
            <input  value="transport_company" type="radio" name="delivery">
            Доставка транспортной компанией
        </label>
    </div>  </div>
</div>

                <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Телефон<sup class="required_star">*</sup></label>
                        <input id="phone_mask" required name="phone" type="text" class="input" placeholder="Телефон">
                        <p class="help"><sup class="required_star">*</sup>обязательное поле</p>
                    </div>
                       <div class="field">
                        <label class="label">Контактное лицо<sup class="required_star">*</sup></label>
                        <input required name="person"  type="text" class="input" placeholder="Контактное лицо">
                    </div>
                    <div class="field">
                        <label class="label">Адрес</label>
                        <input name="address"  type="text" class="input" placeholder="Адрес">
                    </div>
                    <div class="field">
                        <label class="label">e-mail</label>
                        <input name="email" type="email" class="input" placeholder="e-mail">
                    </div>

                </div>
                </div>


                <div class="field is-horizontal">

                    <div class="field-body">


                        <div class="field">

                            <div class="control">
                                <button :disabled="!sum_total" type="submit" class="button is-primary" style="float:right;">
                                    Оставить заявку
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                @endverbatim
            </form>

    <br clear="all">

     <form action="/cart" method="POST" style="margin-top: -2em;">
            @csrf
            @method('DELETE')
            <div zclass="field">

                <div zclass="control">
                    <button onclick="return confirm('Действительно ОЧИСТИТЬ корзину?')" type="submit" class="button is-small is-info is-outlined">
                        Очистить корзину</button>
                </div>
            </div>
        </form>
    <br clear="all"> <br clear="all">


<script>
    new Vue({
        el: '#vueapp_cart',
        data: {
            cart_products: @json($cart_products),
            cart_items: @json($cart_items),

            },
        updated: function () {
            $.post('/ajax/cart_update',
                {cart_items: JSON.stringify(this.cart_items)},
                function () {
            });
        },
        computed: {

            sum_total(){
                sum = 0;
                Object.entries(this.cart_items).forEach(([key, val]) => {

                    sum += this.cart_products[key].public_price * val;
                });

                return sum;
            },


        },
        // mounted() {
        // },
        // created(){
        // },

        methods:{
            checkbox_click(module){
                module.selected = (module.selected ) ? 0 : 1;

            },
            delete_item(product_id){
                this.cart_items[product_id]=0;
            }

        }

    });
</script>



@endsection
