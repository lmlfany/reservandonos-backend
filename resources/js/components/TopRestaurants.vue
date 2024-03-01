<template>
<v-container class="d-flex align-items-center flex-column" style="margin-top: 40px;">
    <h1>Top 5 Restaurantes Más Reservados</h1>
    <div>
      <v-table>
        <thead>
          <tr>
            <th>Lugar</th>
            <th>Reservas</th>
            <th>Likes</th>
            <th>Cliente Más Frecuente</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(restaurant, index) in topRestaurants" :key="index">
            <td>{{ restaurant.name }}</td>
            <td>{{ restaurant.total_reservations }}</td>
            <td>{{ restaurant.likes_count }}</td>
            <td>{{ restaurant.most_frequent_client }}</td>
          </tr>
        </tbody>
      </v-table>
    </div>
</v-container>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            topRestaurants: []
        };
    },
    mounted() {
        axios.get('/fetch-top-restaurants')
            .then(response => {
                this.topRestaurants = response.data;
                console.log(this.topRestaurants)
            })
            .catch(error => {
                console.error('Error al obtener los datos de los restaurantes:', error);
            });
    }
};
</script>
