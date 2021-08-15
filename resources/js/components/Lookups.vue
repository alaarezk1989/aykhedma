<template>
        <div class="row">
            <div class="col-lg-6">
                <div class="headr-select">
                    <select class="btn-block" name="activity" v-model="selectedActivity" >
                        <option value=" ">اختر النشاط </option>
                        <option v-for="activity in activities" :value="activity.id">
                            {{ activity.name }}
                        </option>
                    </select>
                    <img src="/assets/img/Icons/home.png" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="headr-select">
                    <select class="btn-block" v-model="selectedCity" @change="initAreas()">
                        <option value=" ">اختر المحافظة </option>
                        <option v-for="city in cities" :value="city.id">
                            {{ city.name }}
                        </option>
                    </select>
                    <img src="/assets/img/Icons/map.png" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="headr-select">
                    <select class="btn-block" v-model="selectedArea" @change="initZones()">
                        <option value=" ">اختر المدينة </option>
                        <option v-for="area in areas" :value="area.id">
                            {{ area.name }}
                        </option>
                    </select>
                    <img src="/assets/img/Icons/home.png" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="headr-select">
                    <select class="btn-block" name="zone" v-model="selectedZone" >
                        <option value=" ">اختر المنطقة </option>
                        <option v-for="zone in zones" :value="zone.id">
                            {{ zone.name }}
                        </option>
                    </select>
                    <img src="/assets/img/Icons/home.png" alt="">
                </div>
            </div>
        </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data(){
            return {
                cities: [],
                selectedCity: ' ',
                areas: [],
                selectedArea: ' ',
                zones: [],
                selectedZone: ' ',
                activities: [],
                selectedActivity: ' ',
            }
        },
        methods: {
            initAreas(){
                axios.get(
                    route('api.locations.index', {flat: true, parent: this.selectedCity}),
                    {headers: {'Accept-Language': App.locale}}
                )
                .then((response) => {
                    this.areas = response.data;
                    this.selectedArea = ' ';
                })
                .catch((e) => {
                    console.error(e)
                })
            },
            initZones(){
                axios.get(
                    route('api.locations.index', {flat: true, parent: this.selectedArea}),
                    {headers: {'Accept-Language': App.locale}}
                )
                .then((response) => {
                    this.zones = response.data;
                    this.selectedZone = ' ';
                })
                .catch((e) => {
                    console.error(e)
                })
            }
        },
        mounted() {
            axios.get(
                route('api.locations.index', {flat: true}),
                {headers: {'Accept-Language': App.locale}}
            )
            .then((response) => {
                this.cities = response.data;
            })
            .catch((e) => {
                console.error(e)
            });

            axios.get(
                route('api.activities.index', {flat: true}),
                {headers: {'Accept-Language': App.locale}}
            )
            .then((response) => {
                this.activities = response.data;
            })
            .catch((e) => {
                console.error(e)
            })
        }
    }
</script>
