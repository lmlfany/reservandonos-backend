<template>
    <v-container class="d-flex align-items-center flex-column" style="margin-top: 60px;">
      <!-- <p>{{ formattedPlaceId }}</p> -->

      <v-row >
        <v-col cols="12" md="6" >
            <div class="imageForm" :style="{ backgroundImage: 'url(' + place.image_url + ')' }">
                <div style="background-color: rgb(0 0 0 / 40%);">
                    <v-card-text class="text-white"  >
                        <h1 class="text-center">{{ place.name }}</h1>
                        <h2 class="text-center mb-4"> {{ place.location }}</h2>
                        <v-btn tile outlined dark @click="redirectToDetailPage(place.id)">Ver detalles</v-btn>
                    </v-card-text>
                </div>
            </div>
        </v-col>

        <v-col cols="12" md="6">
            <v-card-text class="mt-12">
                <v-row align="center" justify="left">
                    <v-avatar class="mr-1">
                        <v-img :src="place.logo_url" alt="Place Logo"></v-img>
                    </v-avatar>
                    <v-card-title>{{ place.name }}</v-card-title>
                </v-row>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="12">
                        <form @submit.prevent="submitForm">
                            <v-row>
                               <v-col cols="12" sm="6">
                                    <v-text-field
                                        label="Nombre"
                                        outlined
                                        dense
                                        color="blue"
                                        autocomplete="false"
                                        class="mt-4"
                                        v-model="clientName"
                                    />
                               </v-col>
                               <v-col cols="12" sm="6">
                                    <v-text-field
                                        label="Apellido"
                                        outlined
                                        dense
                                        color="blue"
                                        autocomplete="false"
                                        class="mt-4"
                                        v-model="clientLast"
                                    />
                                </v-col>
                            </v-row>
                            <v-text-field
                                label="Fecha de reserva"
                                outlined
                                dense
                                color="blue"
                                autocomplete="false"
                                v-model="reservationDate"
                                type="date" @input="updateAvailableTimes"
                            />
                            <v-select v-model="reservationTime" :items="availableTimes"
                                label="Hora de Reserva">
                            </v-select>
                            <v-btn color="blue" dark block tile type="submit">Reservar</v-btn>
                        </form>
                    <v-row>
                </v-row>
            </v-col>
        </v-row>
    </v-card-text>
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

            let currentHour = startTime[0];
            let currentMinute = startTime[1];

            while (!(currentHour === endTime[0] && currentMinute === endTime[1])) {
                if (currentHour >= 24) {
                    currentHour -= 24;
                }

                const formattedHour = `${currentHour.toString().padStart(2, '0')}:${currentMinute.toString().padStart(2, '0')}`;
                availableTimes.value.push(formattedHour);

                currentMinute += 30;
                if (currentMinute >= 60) {
                    currentHour += 1;
                    currentMinute -= 60;
                }
            }
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
  },
  methods: {
    redirectToDetailPage(placeId) {

        window.location.href = `/place-detail/${placeId}`;

},
  }
};
</script>

<style>
    .imageForm {
        text-align: center;
        padding: 180px 0;
        background-size: cover;
        background-position: right;
        height: 600px;
    }

</style>
