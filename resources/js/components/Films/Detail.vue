<template>
    <div class="mt-5">

        <div class="movie-card">
            <div class="movie-header manOfSteel"  v-bind:style="{ backgroundImage: 'url(/storage/' + filmData.data.photo + ')' }">
                <div class="header-icon-container">
                    <a href="#">
                        <i class="material-icons header-icon"></i>
                    </a>
                </div>
            </div><!--movie-header-->
            <div class="movie-content">
                <div class="movie-content-header">
                    <a href="#">
                        <h3 class="movie-title">{{ filmData.data.name }}</h3>
                    </a>
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Release Date</label>
                        <span>{{ filmData.data.release_date | moment("dddd, MMMM Do YYYY") }}</span>
                    </div><!--date,time-->
                    <div class="info-section">
                        <label>Rating</label>
                        <span class="fa fa-star"
                              v-bind:class="{ checked: index <= filmData.data.rating }"
                              v-for="index in 5"
                              :key="index"
                        ></span>
                    </div><!--screen-->
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Description</label>
                        <span>{{ filmData.data.description }}</span>
                    </div><!--Description-->
                    <div class="info-section"></div>
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Price</label>
                        <span>${{ filmData.data.price }}</span>
                    </div><!--Description-->
                    <div class="info-section"></div>
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Country</label>
                        <span>{{ filmData.data.country.name }}</span>
                    </div><!--Description-->
                    <div class="info-section"></div>
                </div>
            </div><!--movie-content-->
        </div><!--movie-card-->

    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: "Detail",

        props: ["slug"],

        data() {
            return {};
        },
        mounted() {
            this.getFilmData(this.slug);
        },
        computed: {
            ...mapGetters("film", ["filmData"])
        },

        methods: {
            ...mapActions("film", ["getFilmData"]),
        }
    };
</script>
