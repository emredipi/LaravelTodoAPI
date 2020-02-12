<template>
    <div class="container" @keydown="toggle">
        <div class="card-header h1 mb-3">
            News
            <button class="float-right btn btn-primary" @click="fetchNews" :disabled="loading">
                {{this.loading?"Loading...":"Refresh News"}}
            </button>
        </div>
        <div class="row">
            <div v-for="article in articles" class="col-md-3 mb-2">
                <div class="card" @click="setActiveArticle(article)">
                    <img :src="article.urlToImage" :alt="article.title" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{article.title}}</h5>
                    </div>
                    <div class="card-footer">
                        {{article.author}}
                    </div>
                </div>
            </div>
        </div>
        <div class="fade modal" :class="{show:showModal}" v-if="showModal" @click.self="toggle">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{activeArticle.title}}</h5>
                        <button type="button" class="close" @click="toggle">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img :src="activeArticle.urlToImage" :alt="activeArticle.title" class="card-img-top">
                        <p>{{activeArticle.description}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="toggle">Close</button>
                        <a type="button" class="btn btn-primary" target="_blank" :href="activeArticle.url">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "News",
        data(){
            return {
                articles:[],
                activeArticle:null,
                showModal:false,
                loading:true,
            }
        },
        mounted() {
            this.fetchNews();
        },
        methods:{
            toggle(){
                this.showModal=!this.showModal;
            },
            setActiveArticle(article){
                this.activeArticle=article;
                this.toggle();
            },
            fetchNews(){
                this.loading=true;
                this.articles=[];
                let url = 'https://newsapi.org/v2/top-headlines?' +
                    'country=tr&' +
                    'apiKey=a7a9b27383524b4db68fc159218fc201';
                let req = new Request(url);
                fetch(req)
                    .then(response=>response.json())
                    .then(response=>{
                        this.articles=response.articles;
                    })
                    .catch(err=>console.log(err))
                    .then(()=>{
                        this.loading=false;
                    });
            }
        }

    }
</script>

<style scoped>
    img {
        max-width:100%;
    }
    .show {
        background-color:#0000008c;
        display:block !important;
    }
</style>
