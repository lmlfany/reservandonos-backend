<template>
    <div class="d-flex align-items-center flex-column" style="margin-top: 60px;">
      <v-row >
        <v-col v-for="(place, index) in places" :key="index" cols="12" md="4">
          <v-card class="mb-4 fill-height" style="max-height: 600px;">
            <!-- Botón de "Me gusta" -->
            <v-btn class="btn-like" @click="toggleLike(place)">
              <v-icon :color="place.liked ? 'red' : 'grey'">fa fa-heart</v-icon>
            </v-btn>
            <!-- Imagen del lugar -->
            <v-img :src="place.image_url" alt="Place Image" height="200px" cover></v-img>
            <v-card-item class="d-flex" >
                <v-card-text>

                    <v-row align="center">
                      <!-- Logo del lugar -->
                      <v-avatar class="mr-2">
                        <v-img :src="place.logo_url" alt="Place Logo"></v-img>
                      </v-avatar>
                      <h5 class="card-title">{{ place.name }}</h5>
                    </v-row>
                </v-card-text>
              <div style="margin-top: 16px;">
                <!-- Categorías del lugar -->
                <v-chip-group class="px-4">
                    <v-chip v-for="category in place.categories.split(',')" :key="category" outlined>{{ category }}</v-chip>
                </v-chip-group>
                <v-card-text>

                    <p class="card-text">{{ place.schedule }}</p>
                    <p class="card-text">{{ place.location }}</p>
                    <v-row class="mt-2 mb-1 justify-center">
                        <p class="card-text">{{ place.price_range }}</p>
                        <v-icon v-for="n in place.score" :key="n" color="yellow" >fa fa-star</v-icon>
                    </v-row>
                    <v-btn color="primary" @click="redirectToReservationForm(place.id)">Reservar</v-btn>
                </v-card-text>
              </div>
            </v-card-item>
          </v-card>
        </v-col>
      </v-row>
      <v-btn @click="loadMore" class="btn btn-primary mt-4">Mostrar más</v-btn>
    </div>
</template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        places: [],
        nextPage: 0,
        perPage: 9
      };
    },
    mounted() {
      this.fetchPlaces();
    },
    methods: {
      async fetchPlaces() {
        try {
          const response = await axios.get('/places');
          this.places = response.data.places.slice(0, this.perPage);
        } catch (error) {
          console.error('Error fetching places:', error);
        }
      },
      async loadMore() {
        try {
          const response = await axios.get(`/places?page=${this.nextPage}`);
          const newPlaces = response.data.places;
          if (newPlaces.length > 0) {
            this.places = [...this.places, ...newPlaces];
            this.nextPage++;
          } else {
            console.log('No hay más lugares disponibles');
          }
        } catch (error) {
          console.error('Error fetching more places:', error);
        }
      },
      toggleLike(place) {
        place.liked = !place.liked;
      },
      redirectToReservationForm(placeId) {
    window.location.href = `/reservation-form?placeId=${placeId}`;
}
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


.card-title {
  font-size: 1.25rem;
  margin-top: 8px;
}
  </style>
