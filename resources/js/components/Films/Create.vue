<template>
    <div class="create mt-5">
        <div class="card">
            <div class="card-header">
                Create Film
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': errors.name }"
                            id="name"
                            v-model="details.name"
                            placeholder="Enter film name"
                        />
                        <div class="invalid-feedback" v-if="errors.name">
                            {{ errors.name[0] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': errors.description }"
                            id="description"
                            v-model="details.description"
                            placeholder="Enter film description"
                        ></textarea>
                        <div class="invalid-feedback" v-if="errors.description">
                            {{ errors.description[0] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Release Date</label>
                        <datepicker
                            v-model="details.release_date"
                            @selected="onDateChange"
                            :input-class="{'form-control': true}"
                            :format="'MM-dd-yyyy'"
                        ></datepicker>
                        <div class="invalid-feedback" style="display:block;" v-if="errors.release_date">
                            {{ errors.release_date[0] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select v-model="details.rating" id="rating"
                                class="form-control"
                                :class="{ 'is-invalid': errors.rating }">
                            <option value="null" selected>Select Rating</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div class="invalid-feedback" v-if="errors.rating">
                            {{ errors.rating[0] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input
                            type="number"
                            class="form-control"
                            :class="{ 'is-invalid': errors.price }"
                            id="price"
                            v-model="details.price"
                            placeholder="Enter film price"
                        />
                        <div class="invalid-feedback" v-if="errors.price">
                            {{ errors.price[0] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="country">Country</label>
                        <select v-model="details.country" id="country"
                                class="form-control"
                                :class="{ 'is-invalid': errors.country }">
                            <option v-for="item in countries.data" :value="item.id" :key="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                        <div class="invalid-feedback" v-if="errors.country">
                            {{ errors.country[0] }}
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" accept="image/jpeg" @change="onSelectPhoto">
                        <div class="invalid-feedback" style="display:block;" v-if="errors.photo">
                            {{ errors.photo[0] }}
                        </div>
                        <div style="max-width: 100px;">
                            <img :src="previewImage" id="photo" class="img-fluid"/>
                        </div>
                    </div>

                    <button type="button" @click="create" class="btn btn-primary">
                        Add Film
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";

    export default {
        name: "Create",

        data() {
            return {
                details: {
                    name: null,
                    description: null,
                    release_date: new Date(),
                    rating: null,
                    price: 0.00,
                    country: null,
                    photo: null
                },
                previewImage: null,
            };
        },

        computed: {
            ...mapGetters({
                "errors": "errors",
                "countries": "film/countryCollectionData"
            }),
        },

        mounted() {
            this.$store.commit("setErrors", {});
            /**
             * Get countries list
             */
            this.getCountriesCollectionData();
        },

        methods: {
            ...mapActions("film", ["createFilmRequest", "getCountriesCollectionData"]),

            create() {
                const data = this.makeFormData();
                this.createFilmRequest(data).then(() => {
                    this.$router.push({ name: "Films" });
                });
            },

            onDateChange(event){
                this.details.release_date = event;
            },

            onSelectPhoto(event) {
                const image = event.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.previewImage = e.target.result;
                    this.details.photo = image;
                };
            },

            makeFormData() {
                const fd = new FormData();
                for (let [key, value] of Object.entries(this.details)) {
                    if(value === null){
                        continue;
                    }
                    switch (key) {
                        case 'photo':
                            fd.append(key, value, value.name);
                        break;
                        case 'release_date':
                            fd.append(key, this.$moment(value).format('MM-DD-YYYY'));
                        break;
                        default:
                            fd.append(key, value);
                    }
                }
                return fd;
            }
        }
    };
</script>
