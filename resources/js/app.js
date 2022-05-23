require('./bootstrap');
window.Vue = require('vue').default;

// https://dev.to/lvtdeveloper/laravel-vue-router-tutorial-1965
import VueRouter from "vue-router"

Vue.use(VueRouter);

const routes = [
    //Auth Urls
    //https://shouts.dev/laravel-spa-with-vue3-auth-crud-example
    { path:"/register" ,component: require('./components/auth/Register.vue').default,name:"register" },
    { path:"/login" ,component: require('./components/auth/Login.vue').default,name:"login" },

    { path:"/" ,component: require('./components/Home.vue').default,name:"home" },

    //Room Urls
    { path:"/rooms/:room_token/" ,component: require('./components/room/Room.vue').default,name:"room",props:true },
    
];

const router = new VueRouter({
    routes:routes,
   //mode:"history"
});


const app = new Vue({
    router:router,
    el: '#app',
});