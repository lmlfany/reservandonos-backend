<template>
    <v-card :loading="loading" class="mx-auto my-12" max-width="1200" v-if="placeDetail">
      <v-row>
        <v-col cols="6">
          <v-card-item>
            <v-row align="center" justify="left">
                    <v-avatar class="mr-2">
                        <v-img :src="placeDetail.logo_img" alt="Place Logo"></v-img>
                    </v-avatar>
                    <v-card-title class="text-h6">{{ placeDetail.name }}</v-card-title>
                </v-row>
            <v-card-title class="text-subtitle-1 mt-6"> Rango de precio: {{ placeDetail.range_price }}</v-card-title>
            <v-card-text class="mt-4">

                <!-- Horarios de trabajo -->
                <v-divider class="mx-4 mb-1"></v-divider>
                <v-card-title>Horarios de trabajo</v-card-title>

                <div class="px-4">
                  <v-chip-group v-if="placeDetail.schedules && placeDetail.schedules.length > 0">
                    <v-chip v-for="schedule in placeDetail.schedules" :key="schedule.weekday">
                      {{ schedule.weekday }}: {{ schedule.start }} - {{ schedule.end }}
                    </v-chip>
                </v-chip-group>
                  <span v-else>No se han encontrado horarios de trabajo.</span>
                </div>

                <!-- Amenidades del lugar -->
                <v-divider class="mx-4 mb-1"></v-divider>
                <v-card-title class="mt-8">Amenidades</v-card-title>
                <div class="px-4">
                    <ul>
                    <li v-for="amenity in placeDetail.amenities" :key="amenity.id">{{ amenity.name }}</li>
                </ul>
                <span v-if="!placeDetail.amenities || placeDetail.amenities.length === 0">No se han encontrado amenidades.</span>
                </div>



                <!-- Botones -->
                <div class="text-center mt-4">
                    <v-btn color="blue" dark block tile class="mt-16" @click="redirectToReservationForm(placeId)">Reservar</v-btn>
                    <v-btn class="btn-like"  @click="likePlace(placeId)">
                        <v-icon :color="placeDetail.liked  ? 'red' : 'grey'">fa fa-heart</v-icon>
                    </v-btn>

                </div>
            </v-card-text>
        </v-card-item>
    </v-col>

    <v-col cols="6">
        <v-card-title v-if="placeDetail.gallery && placeDetail.gallery.length > 0" ></v-card-title>
        <v-carousel :show-arrows="false" hide-delimiters
            v-if="placeDetail.gallery && placeDetail.gallery.length > 0"
                cycle
                height="600"
                hide-delimiter-background
                progress="primary"
            >
            <v-carousel-item
                v-for="(image, index) in placeDetail.gallery"
                    :key="index"
                >
                <v-sheet height="100%">
                    <v-img :src="image.file" aspect-ratio="1" contain="cover" :preload="index === 0"></v-img>
                </v-sheet>
            </v-carousel-item>
        </v-carousel>

    </v-col>


      </v-row>
    </v-card>
    <span v-else>Cargando detalles del lugar...</span>

    <!-- Descripcion -->
    <v-divider></v-divider>
    <!-- <v-container>

        <div v-html="placeDetail.description"></div>
    </v-container> -->

  </template>

<script>
import axios from 'axios';
export default {
  props: {
    placeId: {
      type: Number,
      required: true
    },
    placeDetails: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      loading: false,
      placeDetail: {}
    };
  },
  mounted() {
    this.placeDetail = this.$props.placeDetails;

    if (!this.placeDetail || typeof this.placeDetail !== 'object') {
      console.error('Invalid place details provided.');
      return;
    }
    this.placeDetail.gallery = JSON.parse(this.placeDetail.gallery);
    this.placeDetail.schedules = JSON.parse(this.placeDetail.schedules);
    this.placeDetail.amenities = JSON.parse(this.placeDetail.amenities);
        // this.placeDetail.description = JSON.parse(this.placeDetail.description);
  },
  methods: {
    reserve() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);
    },
    redirectToReservationForm(placeId) {
        window.location.href = `/reservation-form?placeId=${placeId}`;
},
async likePlace(placeId) {
    try {
        const response = await axios.post(`/place/${placeId}/likes`);
        console.log(response.data.message);
        this.placeDetail.liked = true;
    } catch (error) {
        console.error('Error al dar "me gusta" al lugar:', error);
    }
},

  }
};
</script>

<style>
    .btn-like {
      position: absolute;
      top: 8px;
      right: 8px;
      z-index: 1;
    }
  .liked .btn-like i {
    color: red;
  }


</style>
