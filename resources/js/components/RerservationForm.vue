<template>
    <v-container class="d-flex align-items-center flex-column" style="margin-top: 60px;">
        <form @submit.prevent="submitForm">
            <p>{{ formattedPlaceId }}</p>
          <v-text-field v-model="clientName" label="First Name"></v-text-field>
          <v-date-picker v-model="reservationDate" label="Reservation Date"></v-date-picker>


          <v-btn type="submit">Submit</v-btn>
        </form>
    </v-container>
  </template>

<script>
import { ref, computed } from 'vue';
import axios from 'axios';

export default {
  props: ['placeId'],
  setup(props) {
    const clientName = ref('');
    const reservationDate = ref(null);

    const formattedPlaceId = computed(() => {

      return `Place ID: ${props.placeId}`;
    });

    const submitForm = async () => {
      try {
        if (!props.placeId) {
          console.error('placeId is undefined');
          return;
        }

        await axios.post(`/reservations?placeId=${props.placeId}`, {
          client_name: clientName.value,
          reservation_date: reservationDate.value
        });

        alert('Reservation created successfully!');
      } catch (error) {
        console.error('Error creating reservation:', error);
      }
    };

    return {
      clientName,
      reservationDate,
      submitForm,
      formattedPlaceId
    };
  }
};
</script>
