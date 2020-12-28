<template>
    <div class="container" @keydown="toggle">
        <div class="row card-header h1 mb-3">
            <div class="col-sm-12 col-md-8">News</div>
            <div class="col-sm-12 col-md-4">
                <div class="float-right">
                    <label>
                        <select class="form-control" v-model="category">
                            <option
                                v-for="category in categories()"
                                :value="category"
                            >
                                {{ category }}
                            </option>
                        </select>
                        <button class="btn btn-primary btn-group-sm w-100" @click="fetchNews" :disabled="loading">
                            {{ this.loading ? "Loading..." : "Refresh News" }}
                        </button>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div v-for="article in articles" class="col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="card" @click="setActiveArticle(article)">
                    <img :src="article.urlToImage" :alt="article.title" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ article.title }}</h5>
                    </div>
                    <div class="card-footer">
                        {{ article.author }}
                    </div>
                </div>
            </div>
        </div>
        <div class="fade modal" :class="{show:showModal}" v-if="showModal" @click.self="toggle">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ activeArticle.title }}</h5>
                        <button type="button" class="close" @click="toggle">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overscroll-behavior-y: auto">
                        <img :src="activeArticle.urlToImage" :alt="activeArticle.title" class="card-img-top">
                        <p>{{ activeArticle.description }}</p>
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
    data() {
        return {
            articles: [],
            activeArticle: null,
            showModal: false,
            loading: true,
            category: "General",
        }
    },
    mounted() {
        this.fetchNews();
    },
    watch: {
        category: function () {
            this.fetchNews();
        }
    },
    methods: {
        categories: () => {
            return {
                "general": "General",
                "business": "Business",
                "entertainment": "Entertainment",
                "health": "Health",
                "science": "Science",
                "sports": "Sports",
                "technology": "Technology",
            }
        },

        toggle() {
            this.showModal = !this.showModal;
        },
        setActiveArticle(article) {
            this.activeArticle = article;
            this.toggle();
        },
        fetchNews() {
            this.loading = true;
            this.articles = [];


            axios.get("news?category=" + this.category)
            .then(response => {
                this.articles = response.data.articles;
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(() => {
                this.loading = false;
            });
        }
    }

}
</script>

<style scoped>
img {
    max-width: 100%;
}

.show {
    background-color: #0000008c;
    display: block !important;
}
</style>
