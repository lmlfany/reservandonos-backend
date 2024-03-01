import './bootstrap';
import { createApp } from 'vue';
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'


import { aliases, fa } from 'vuetify/iconsets/fa-svg'
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';


library.add(fas);
library.add(far);

import ExampleComponent from './components/ExampleComponent.vue';
import Cards from './components/Cards.vue';
import Navbar from './components/Navbar.vue';
import Reservation from './components/RerservationForm.vue';
import PlaceDetail from './components/PlaceDetail.vue';
import TopRestaurants from './components/TopRestaurants.vue';

const app = createApp({});

app.component('example-component', ExampleComponent);
app.component('cards', Cards);
app.component('navbar', Navbar);
app.component('reservation-form', Reservation);
app.component('place-detail', PlaceDetail);
app.component('top-restaurants', TopRestaurants);

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'fa',
        aliases,
        sets: {
          fa,
        },
      },
});

app.use(vuetify).component('font-awesome-icon', FontAwesomeIcon).mount('#app');
