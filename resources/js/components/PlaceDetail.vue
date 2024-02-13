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
            <v-img :src="place.image_url" alt="Place Image" height="200px" cover @click="fetchPlaceDetails(place.id)"></v-img>
            <v-card-item class="d-flex" >
                <v-card-text>

                    <v-row align="center">
                      <!-- Logo del lugar -->
                      <v-avatar class="mr-2">
                        <v-img :src="place.logo_url" alt="Place Logo"></v-img>
                      </v-avatar>
                      <h5 class="card-title" @click="fetchPlaceDetails(place.id)">{{ place.name }}</h5>
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
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
