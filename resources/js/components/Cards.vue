<template>
    <v-container class="d-flex align-items-center flex-column" style="margin-top: 60px;">
      <v-row >
        <v-col v-for="(place, index) in placesToShow" :key="index" cols="12" md="4">
          <v-card class="mb-4 fill-height" style="max-height: 600px;">
            <!-- Botón de "Me gusta" -->
            <v-btn class="btn-like" @click="likePlace(place.id)">
                <v-icon :color="place.liked ? 'red' : 'grey'">fa fa-heart</v-icon>
            </v-btn>
            <!-- Imagen del lugar -->
            <v-img :src="place.image_url" alt="Place Image" height="200px" cover @click="redirectToDetailPage(place.id)"></v-img>
            <v-card-item class="d-flex" >
                <v-card-text>
                    <v-row align="center">
                      <!-- Logo del lugar -->
                      <v-avatar class="mr-2">
                        <v-img :src="place.logo_url" alt="Place Logo"></v-img>
                      </v-avatar>
                      <h5 class="card-title" @click="redirectToDetailPage(place.id)">{{ place.name }}</h5>
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
                        <p class="card-text mr-16">{{ place.price_range }}</p>
                        <v-icon v-for="n in place.score" :key="n" color="yellow" >fa fa-star</v-icon>
                    </v-row>
                    <v-row class="mt-2 mb-1 justify-center">
                        <v-btn color="primary" class="mr-16" @click="redirectToReservationForm(place.id)">Reservar</v-btn>
                        <v-btn color="primary" @click="redirectToDetailPage(place.id)">Ver detalles</v-btn>
                    </v-row>
                </v-card-text>
              </div>
            </v-card-item>
          </v-card>
        </v-col>
      </v-row>
      <v-btn @click="loadMore" class="btn btn-primary mt-4">Mostrar más</v-btn>
    </v-container>
</template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        places: [],
        placesToShow: [],
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
          this.places = response.data.places;
            this.loadMore();
        } catch (error) {
          console.error('Error fetching places:', error);
        }
      },
      loadMore() {
      const startIndex = this.nextPage * this.perPage;
      const endIndex = startIndex + this.perPage;
      const newPlaces = this.places.slice(startIndex, endIndex);
      if (newPlaces.length > 0) {
        this.placesToShow = [...this.placesToShow, ...newPlaces];
        this.nextPage++;
      } else {
        console.log('No hay más lugares disponibles');
      }
    },
    async likePlace(placeId) {
    try {
        const place = this.placesToShow.find(place => place.id === placeId);
        if (!place) return;
        const response = await axios.post(`/place/${placeId}/likes`);
        console.log(response.data.message);
        place.liked = true;
    } catch (error) {
        console.error('Error al dar "me gusta" al lugar:', error);
    }
},
redirectToDetailPage(placeId) {

  const detailPageUrl = `/place-detail/${placeId}`;

  window.open(detailPageUrl, '_blank');
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
