<template>
    <div class="home mt-5">

    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: "Create",

        data() {
            return {};
        },

        computed: {
            ...mapGetters("film", ["user"])
        },

        methods: {
            ...mapActions("film", ["createFilmRequest"]),
        }
    };
</script>
