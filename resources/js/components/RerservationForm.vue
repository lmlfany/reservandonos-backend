<template>
    <v-container class="d-flex align-items-center flex-column" style="margin-top: 60px;">
      <p>{{ formattedPlaceId }}</p>
      <v-row>
        <v-col cols="6">
          <v-img :src="place.image_url" alt="Place Image" height="600px" width="600px" cover></v-img>
        </v-col>
        <v-col cols="6">
          <v-card>
            <v-card-item>
              <v-row align="center">
                <v-avatar class="mr-2">
                  <v-img :src="place.logo_url" alt="Place Logo"></v-img>
                </v-avatar>
                <v-card-title>{{ place.name }}</v-card-title>
              </v-row>
            </v-card-item>
            <v-card-item>
              <v-card-text>
                <form @submit.prevent="submitForm">
                  <v-text-field v-model="clientName" label="Nombre"></v-text-field>
                  <v-text-field v-model="clientLast" label="Apellido"></v-text-field>
                  <v-text-field v-model="reservationDate" label="Fecha de Reserva" type="date" @input="updateAvailableTimes"></v-text-field>
                  <v-select v-model="reservationTime" :items="availableTimes" label="Hora de Reserva"></v-select>
                  <v-btn type="submit">Reservar</v-btn>
                </form>
              </v-card-text>
            </v-card-item>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>

<script>
import { ref, computed } from 'vue';
import axios from 'axios';

export default {
  props: {
    place: {
      type: Object,
      required: true
    },
    placeDetail: {
      type: Object,
      required: true
    }
  },

  setup(props) {
    const clientName = ref('');
    const clientLast = ref('');
    const reservationDate = ref(new Date().toISOString().substr(0, 10));
    const reservationTime = ref('');
    const placeId = ref(props.place.id);
    const formattedPlaceId = computed(() => {
      return `Place ID: ${props.place.id}`;
    });

    const today = new Date().toISOString().substr(0, 10);
    console.log('placeDetail:', props.placeDetail);
    console.log('Tipo de schedules:', Array.isArray(props.placeDetail.schedules));
    console.log(props.placeDetail.schedules);

    const availableTimes = ref([]);

    const getDayOfWeek = (date) => {
      const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
      const dayIndex = new Date(date).getDay();
      return days[dayIndex].toLowerCase();
    };

    const updateAvailableTimes = () => {
        try {

            const parsedSchedules = JSON.parse(props.placeDetail.schedules);
            if (!Array.isArray(parsedSchedules)) {
                console.warn('El campo "schedules" no es una matriz.');
            return;
            }

            const selectedDay = getDayOfWeek(reservationDate.value);
            console.log('Selected Day:', selectedDay);
            availableTimes.value = [];

            const selectedDaySchedule = parsedSchedules.find(schedule => {
                return schedule.weekday.toLowerCase() === selectedDay;
            });

            if (selectedDaySchedule) {
                console.log('Found matching schedule:', selectedDaySchedule);
                const startTime = selectedDaySchedule.start.split(':').map(Number);
                let endTime = selectedDaySchedule.end.split(':').map(Number);

                if (endTime[0] < startTime[0] || (endTime[0] === startTime[0] && endTime[1] < startTime[1])) {
                endTime = [endTime[0] + 24, endTime[1]];
                }

                let currentHour = startTime[0];
                let currentMinute = startTime[1];

                while (!(currentHour === endTime[0] && currentMinute === endTime[1])) {
                    const formattedHour = `${currentHour.toString().padStart(2, '0')}:${currentMinute.toString().padStart(2, '0')}`;
                    availableTimes.value.push(formattedHour);

                    currentMinute += 30;
                    if (currentMinute >= 60) {
                        currentHour += 1;
                        currentMinute -= 60;
                    }
                }

                const formattedEndTime = `${endTime[0].toString().padStart(2, '0')}:${endTime[1].toString().padStart(2, '0')}`;
                availableTimes.value.push( formattedEndTime );
            } else {
                console.log('No schedule available for the selected day.');
            }

            console.log('Available Times:', availableTimes.value);
            } catch (error) {
            console.error('Error in updateAvailableTimes:', error);
        }
    };


    const submitForm = async () => {
      try {
        const formData = {
          client_name: clientName.value,
          client_lastname: clientLast.value,
          place_id: placeId.value,
          reservation_date: reservationDate.value,
          reservation_time: reservationTime.value
        };


        const response = await axios.post(`/reservation/${placeId.value}`, formData);
        alert('Se creó con éxito!');
        console.log('Response:', response.data);
      } catch (error) {
        console.error('Error:', error.response.data);
        alert('Ocurrió un error al procesar la solicitud.');
      }
    };

    return {
      clientName,
      clientLast,
      reservationDate,
      reservationTime,
      formattedPlaceId,
      submitForm,
      availableTimes,
      updateAvailableTimes,
      today
    };
  }
};
</script>
