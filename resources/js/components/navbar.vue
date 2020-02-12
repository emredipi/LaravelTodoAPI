<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Todo App</a>
            <button class="navbar-toggler" type="button" @click="toggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" :class="{show:isMenuOpen}">
                <ul class="navbar-nav mr-auto">
                    <router-link tag="li" active-class="active" v-for="route in routes" class="nav-item" :to="route.path" v-bind:key="route.path">
                        <a class="nav-link" href="#">{{route.text}}</a>
                    </router-link>
                </ul>
                <form class="form-inline my-2 my-lg-0" @submit.prevent="search" v-if="this.$route.name==='todoList'">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" v-model="text">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "navbar",
        props: ['routes'],
        data(){
            return {
                text:"",
                isMenuOpen:false,
            }
        },
        methods:{
            search(){
                window.EventBus.$emit("search",this.text);
                this.text="";
            },
            toggle(){
                this.isMenuOpen=!this.isMenuOpen;
            }
        }
    }
</script>
