<template>
  <q-page padding class="q-gutter-y-md text-center">
    <!-- content -->
    <h1>Welcome</h1>
    <q-input type="tel"  v-model="mobile" rounded label="Mobile" />
    <q-btn @click="login" label="Login" color="primary" class="full-width" rounded />
  </q-page>
</template>

<script setup>
import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const mobile = ref();
const router = useRouter();
function login () {
  api.post('api/sendVerify', {
    username: mobile.value,
  })
    .then((r) => {
      if (r.data.status) {

        router.push('/confirmLogin/' + mobile.value);

      } else {
        Notify.create({
          type: 'negative',
          message: 'SMS Failed',
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
