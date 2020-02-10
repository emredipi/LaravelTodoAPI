<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Todo App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <router-link tag="li" active-class="active" v-for="route in routes" class="nav-item" :to="route.path" v-bind:key="route.path">
                        <a class="nav-link" href="#">{{route.text}}</a>
                    </router-link>
                </ul>
                <form class="form-inline my-2 my-lg-0" @submit.prevent="search">
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
                text:""
            }
        },
        methods:{
            search(){
                window.EventBus.$emit("search",this.text);
                this.text="";
            }
        }
    }
</script>
