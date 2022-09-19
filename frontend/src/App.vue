
<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
         <span class="mr-2">WINFOX</span>
         <span class="mr-2">Рязанов Денис Андреевич</span>
      </div>
      <v-spacer></v-spacer>
       <v-btn
        to="/"
        text
      >
        <span class="mr-2">Регистрация</span>
      </v-btn>
      <v-btn
        to="/registr"
        text
      >
        <span class="mr-2">Зарегистрированные</span>
      </v-btn>
    </v-app-bar>
    <v-main>
      <v-container>
          <router-view/>
      </v-container>
      </v-main>
  </v-app>
</template>

<script>

export default {
  name: 'App',

  components: {
  },

  data: () => ({
    //
  }),
};
</script>