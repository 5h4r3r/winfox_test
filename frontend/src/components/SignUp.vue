<template>
  <validation-observer
    ref="observer"
    v-slot="{ invalid }"
  >
    <form @submit.prevent="submit">
      <validation-provider
        v-slot="{ errors }"
        name="Name"
        rules="required|max:10"
      >
        <v-text-field
          v-model="firstName"
          :counter="10"
          :error-messages="errors"
          label="First Name"
          required
        ></v-text-field>
      </validation-provider>
       <validation-provider
        v-slot="{ errors }"
        name="Name"
        rules="required|max:10"
      >
        <v-text-field
          v-model="lastName"
          :counter="10"
          :error-messages="errors"
          label="Last Name"
          required
        ></v-text-field>
      </validation-provider>
      <validation-provider
        v-slot="{ errors }"
        name="email"
        rules="required|email"
      >
        <v-text-field
          v-model="email"
          :error-messages="errors"
          label="E-mail"
          required
        ></v-text-field>
      </validation-provider>

      <v-btn
        class="mr-4"
        type="submit"
        :disabled="invalid"
        v-on:click="create"
      >
        Зарегистрироваться
      </v-btn>
      <v-btn @click="clear">
        Очистить
      </v-btn>
    </form>
  </validation-observer>
</template>

<script>
  import { required, email, max} from 'vee-validate/dist/rules'
  import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'

  setInteractionMode('eager')

  extend('required', {
    ...required,
    message: '{_field_} can not be empty',
  })

  extend('max', {
    ...max,
    message: '{_field_} may not be greater than {length} characters',
  })

  extend('email', {
    ...email,
    message: 'Email must be valid',
  })

  export default {
    components: {
      ValidationProvider,
      ValidationObserver,
    },
    data: () => ({
      firstName: '',
      lastName: '',
      email: '',
    }),

    methods: {
      submit () {
        this.$refs.observer.validate()
      },
      clear () {
        this.firstName = ''
        this.lastName = ''
        this.email = ''
        this.$refs.observer.reset()
      },
      async create() {
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ firstName: this.firstName, lastName: this.lastName, email: this.email })
      };
      const response = await fetch("https://back_wf.doomsdaycorp.ru/create", requestOptions);
      const data = await response.json();
      this.response = data;
      console.log(data.message)
}
    },
  }
</script>