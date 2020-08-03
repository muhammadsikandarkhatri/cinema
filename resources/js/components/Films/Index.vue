<template>
    <div class="home mt-5">

        <div class="movie-card" v-for="item in filmCollectionData.data" :key="item.id">
            <div class="movie-header manOfSteel">
                <div class="header-icon-container">
                    <a href="#">
                        <i class="material-icons header-icon"></i>
                    </a>
                </div>
            </div><!--movie-header-->
            <div class="movie-content">
                <div class="movie-content-header">
                        <h3 class="movie-title">
                            <router-link class="nav-link" :to="{ path: `/film/${item.slug}` }">
                                {{item.name}}
                            </router-link>
                        </h3>
                    <div class="imax-logo"></div>
                </div>
                <div class="movie-info">
                    <div class="info-section">
                        <label>Date & Time</label>
                        <span>Sun 8 Sept - 10:00PM</span>
                    </div><!--date,time-->
                    <div class="info-section">
                        <label>Screen</label>
                        <span>03</span>
                    </div><!--screen-->
                    <div class="info-section">
                        <label>Row</label>
                        <span>F</span>
                    </div><!--row-->
                    <div class="info-section">
                        <label>Seat</label>
                        <span>21,22</span>
                    </div><!--seat-->
                </div>
            </div><!--movie-content-->
        </div><!--movie-card-->


        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>

    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: "FilmIndex",

        data() {
            return {};
        },

        mounted() {
            this.getFilmCollectionData();
        },

        computed: {
            ...mapGetters("film", ["filmCollectionData"])
        },

        methods: {
            ...mapActions("film", ["getFilmCollectionData", "deleteFilmRequest"]),

            deleteFilm(){
                this.deleteFilmRequest()
                .then(() => {
                    this.$router.push({ name: "Home" });
                    this.getFilmCollectionData();
                });
            }
        }
    };
</script>
