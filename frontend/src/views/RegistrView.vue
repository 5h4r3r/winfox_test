<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
         <th class="text-left">
            ID
          </th>
          <th class="text-left">
            First Name
          </th>
          <th class="text-left">
            Last Name
          </th>
          <th class="text-left">
            Email
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in table"
          :key="item.name"
        >
          <td>{{ item.id }}</td>
          <td>{{ item.last_name }}</td>
          <td>{{ item.first_name }}</td>
          <td>{{ item.email }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
 export default {
    data: () => ({
      table: '',
      firstName: '',
      lastName: '',
      email: '',
    }),
created(){
        fetch("https://back_wf.doomsdaycorp.ru/read")
          .then(response => response.json())
          .then(data => (this.table = data));
          // .then(data => (data.forEach((element) => { this.firstName = element.first_name; console.log(element)})));
    },
    methods: {
 async read() {
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ firstName: this.firstName, lastName: this.lastName, email: this.email })
      };
      const response = await fetch("https://back_wf.doomsdaycorp.ru/create", requestOptions);
      const data = await response.json();
      this.response = data.id;
}
    }
    
 }
</script>