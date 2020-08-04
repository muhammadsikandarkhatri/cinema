<template>
    <div class="home mt-5">

        <div class="movie-card" v-for="item in filmCollectionData.data" :key="item.id">
            <div class="movie-header manOfSteel" v-bind:style="{ backgroundImage: 'url(/storage/' + item.photo + ')' }">
                <div class="header-icon-container">
                    <a href="#">
                        <i class="material-icons header-icon"></i>
                    </a>
                </div>
            </div><!--movie-header-->
            <div class="movie-content">
                <div class="movie-content-header">
                    <h3 class="movie-title">
                        <router-link class="nav-link" :to="{ path: `/film/${item.slug}` }">
                            {{ item.name }}
                        </router-link>
                    </h3>
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Release Date</label>
                        <span>{{ item.release_date | moment("dddd, MMMM Do YYYY") }}</span>
                    </div><!--date,time-->
                    <div class="info-section">
                        <label>Rating</label>
                        <span class="fa fa-star"
                              v-bind:class="{ checked: index <= item.rating }"
                              v-for="index in 5"
                              :key="index"
                        ></span>
                    </div><!--screen-->
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Description</label>
                        <span>{{ item.description }}</span>
                    </div><!--Description-->
                    <div class="info-section"></div>
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Price</label>
                        <span>${{ item.price }}</span>
                    </div><!--Description-->
                    <div class="info-section"></div>
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Country</label>
                        <span>{{ item.country.name }}</span>
                    </div><!--Description-->
                    <div class="info-section"></div>
                </div>
            </div><!--movie-content-->
        </div><!--movie-card-->


        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <button class="page-link"
                            v-on:click="getFilmCollectionData(pagination.prev_page_url)"
                            :disabled="!pagination.prev_page_url"
                    >Previous</button>
                </li>
                <li class="page-item">
                    <button class="page-link">{{ pagination.current_page }} of {{ pagination.last_page }}</button>
                </li>
                <li class="page-item">
                    <button class="page-link"
                            v-on:click="getFilmCollectionData(pagination.next_page_url)"
                            :disabled="!pagination.next_page_url"
                    >Next</button>
                </li>
            </ul>
        </nav>

    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: "FilmIndex",

        data() {
            return {
                url: `${process.env.MIX_VUE_APP_API_URL}films`,
            };
        },

        mounted() {
            this.getFilmCollectionData(this.url);
        },

        computed: {
            ...mapGetters("film", ["filmCollectionData", "pagination"])
        },

        methods: {
            ...mapActions("film", ["getFilmCollectionData", "deleteFilmRequest"]),

            deleteFilm() {
                this.deleteFilmRequest()
                    .then(() => {
                        this.$router.push({name: "FilmIndex"});
                        this.getFilmCollectionData();
                    });
            }
        }
    };
</script>
