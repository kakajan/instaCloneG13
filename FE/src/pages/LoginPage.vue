<template>
  <q-page padding class="q-gutter-y-md text-center">
    <!-- content -->
    <h1>Welcome</h1>
    <q-input v-model="email" rounded label="E-Mail" type="email" />
    <q-input v-model="password" rounded label="Password" type="password" />
    <q-btn @click="login" label="Login" color="primary" class="full-width" rounded />
  </q-page>
</template>

<script setup>
import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const email = ref('ali@gmail.com');
const password = ref(123);
const router = useRouter();
function login () {
  console.log(email.value, password.value);

  api.post('/oauth/token', {
    username: email.value,
    password: password.value,
    grant_type: 'password',
    client_id: 2,
    client_secret: '5fRTvqaub4gbC1pV7elszZbWn844R23hJIHEa75A',
    scope: '*'
  })
    .then((r) => {
      if (r.data.access_token) {
        localStorage.setItem('access_token', r.data.access_token);
        api.defaults.headers = {
          Authorization: 'Bearer ' + localStorage.getItem('access_token'),
          'Content-Type': 'application/json',
          Accept: 'application/json;charset=UTF-8',
        }
        Notify.create({
          type: 'positive',
          message: 'User logged in successfully',
          icon: 'person_add',
        });
        router.push('/posts');

      } else {
        Notify.create({
          type: 'negative',
          message: 'User login failed',
          icon: 'person_add',
        });
      }
    }).catch((e) => {
      console.log(e);
      Notify.create({
        type: 'negative',
        message: 'User login failed',
        icon: 'person_add',
      });
    });
}
</script>
