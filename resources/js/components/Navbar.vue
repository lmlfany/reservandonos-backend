<template>
        <v-app-bar app color="white" flat>
          <v-badge color="primary" dot>
              <v-icon x-large color="grey" icon="fa-home" ></v-icon>
          </v-badge>
          <v-toolbar-title :elevation="8"  class="ml-4">
            <span class="text-blue"> Reservandonos </span>
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-badge color="primary" overlap content="2" class="mr-2 mt-1">
            <v-avatar size="40" color="blue">
              <v-icon x-small color="primary" icon="fa-plus">fa-plus</v-icon>
            </v-avatar>
          </v-badge>
          <v-badge color="primary" overlap content="2" class="mr-2 mt-1">
            <v-avatar size="40" color="blue">
              <v-icon x-small color="primary" icon="fa-check">fa-check</v-icon>
            </v-avatar>
          </v-badge>
          <span class="text-grey d-none d-sm-flex">Test</span>
          <v-avatar size="40" color="primary" class="ml-4">
            <v-icon x-small  icon="fa-solid fa-user">fa-solid fa-user</v-icon>
          </v-avatar>
        </v-app-bar>

</template>

<script>

export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style>
.v-toolbar_title {
  font-size: 1rem !important;
}
</style>
