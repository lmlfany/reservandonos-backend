<template>
    <form @submit.prevent="submitForm">
      <v-text-field v-model="clientName" label="First Name"></v-text-field>
      <v-text-field v-model="clientLastName" label="Last Name"></v-text-field>
      <v-date-picker v-model="reservationDate" label="Reservation Date"></v-date-picker>


      <v-btn type="submit">Submit</v-btn>
    </form>
  </template>

  <script>
  import { ref } from 'vue'
  import axios from 'axios'

  export default {
    props: ['placeId'], // Define la propiedad placeId como un prop

    setup(props) {
      const clientName = ref('')
      const clientLastName = ref('')
      const reservationDate = ref(null)

      const submitForm = async () => {
        try {
          // Utiliza el ID del lugar recibido como prop
          await axios.post(`/web/reservations?placeId=${props.placeId}`, {
            client_name: clientName.value,
            client_lastname: clientLastName.value,
            reservation_date: reservationDate.value
          })

          alert('Reservation created successfully!')
        } catch (error) {
          console.error('Error creating reservation:', error)
        }
      }

      return {
        clientName,
        clientLastName,
        reservationDate,
        submitForm
      }
    }
  }
  </script>
