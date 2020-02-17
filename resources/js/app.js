import  Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import Navbar from "../js/components/navbar";
require("./bootstrap");
Vue.use(VueRouter);
window.EventBus=new Vue();
const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    data(){
        return {
            routes:routes.routes,
        };
    },
    components: {Navbar}
});
