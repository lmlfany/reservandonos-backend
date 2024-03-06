<template>
    <v-app-bar app color="white" flat>
      <!-- Botón para ir a la pantalla principal -->
      <v-btn text @click="goToHomePage">
        <v-badge color="primary" dot>
          <v-icon x-large color="grey" icon="fa-home"></v-icon>
        </v-badge>
      </v-btn>
      <v-toolbar-title :elevation="8" class="ml-4">
        <span class="text-blue" @click="goToHomePage"> Reservandonos test </span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn text @click="goToLikesAndReservations">
        Likes & Reservaciones
      </v-btn>
      <v-avatar size="40" color="primary" class="ml-4">
        <v-icon x-small icon="fa-solid fa-user">fa-solid fa-user</v-icon>
      </v-avatar>
    </v-app-bar>
  </template>

  <script>
  export default {
    methods: {
      goToHomePage() {
        window.location.href = `/`;
      },
      goToLikesAndReservations() {
        window.location.href = '/top-restaurants';
      },
    },
    mounted() {
      console.log('Funciona');
    },
  };
  </script>

  <style>
  .v-toolbar_title {
    font-size: 1rem !important;
  }
  </style>
