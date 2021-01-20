


// import Vue from 'vue'
// window.Vue = require('vue');
import Vue from 'vue'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import App from "./components/mycomponent.vue";

// import style
import 'swiper/css/swiper.css'

Vue.use(VueAwesomeSwiper, /* { default options with global component } */)

// Vue.component('mycomponent', require('./components/mycomponent.vue'));

new Vue({
    el: "#app",
    template: "<App/>",
    components: { App }
});


$(document).ready(function() {

    // Check for click events on the navbar burger icon
    $("#top_nav").click(function() {

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");

    });
});
