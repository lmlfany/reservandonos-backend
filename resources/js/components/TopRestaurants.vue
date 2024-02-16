<template>
    <div>
      <h1>Top 5 Restaurantes Más Reservados</h1>
      <table>
        <thead>
          <tr>
            <th>Lugar</th>
            <th>Reservas</th>
            <th>Cliente Más Frecuente</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(restaurant, index) in topRestaurants" :key="index">
            <td>{{ restaurant.name }}</td>
            <td>{{ restaurant.total_reservations }}</td>
            <td>{{ restaurant.most_frequent_client }}</td>
          </tr>
        </tbody>
      </table>
    </div>
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
        axios.get('/top-restaurants')
        .then(response => {
        this.topRestaurants = response.data;
        })
        .catch(error => {
        console.error('Error al obtener los datos de los restaurantes:', error);
      });

      this.topRestaurants = [
        { name: 'Restaurante 1', total_reservations: 10, most_frequent_client: 'Cliente 1' },
        { name: 'Restaurante 2', total_reservations: 8, most_frequent_client: 'Cliente 2' },
        { name: 'Restaurante 3', total_reservations: 6, most_frequent_client: 'Cliente 3' },
        { name: 'Restaurante 4', total_reservations: 5, most_frequent_client: 'Cliente 4' },
        { name: 'Restaurante 5', total_reservations: 4, most_frequent_client: 'Cliente 5' }
      ];
    }
  };
  </script>

  <style>

  </style>
