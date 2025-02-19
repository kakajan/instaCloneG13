<template>
  <q-page padding class="flex flex-center">
    <!-- content -->
    <tion class="q-gutter-y-md text-center">
      <h1 class=" q-mt-lg q-my-none text-h5 text-weight-bolder text-grey-9">Register form</h1>
      <div class="row q-col-gutter-sm">
        <div class="col-6">
          <q-input rounded outlined v-model="name" label="Name" />
        </div>
        <div class="col-6">
          <q-input rounded outlined v-model="email" label="Email" />
        </div>
        <div class="col-6">
          <q-input :type="isPwd ? 'password' : 'text'" rounded outlined v-model="password" label="Password">

            <template v-slot:append>
              <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer" @click="isPwd = !isPwd" />
            </template>

          </q-input>
        </div>
        <div class="col-6">
          <q-input type="password" rounded outlined v-model="confirmPassword" label="Confirm Password" />
        </div>
      </div>
      <q-btn @click="register" icon="person_add" label="register" color="primary" rounded />
    </tion>
  </q-page>
</template>

<script setup>
import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const name = ref('usher');
const email = ref('faslolkhitab@gmail.com');
const password = ref('123');
const confirmPassword = ref('123');
const isPwd = ref(true);
function register () {
  if (password.value === confirmPassword.value) {
    api.post('/api/users', {
      name: name.value,
      email: email.value,
      password: password.value,
    })
      .then((r) => {
        if (r.data.stat === 1) {
          Notify.create({
            type: 'positive',
            message: 'User registered successfully',
            icon: 'person_add',
          });
          router.push('/login');
        }
        else if (r.data.stat === 0) {
          Notify.create({
            type: 'negative',
            message: 'User already exists',
            icon: 'person_add',
          });
        } else {
          Notify.create({
            type: 'negative',
            message: 'User registration failed',
            icon: 'person_add',
          });
        }
      }).catch((e) => {
        console.log(e);
        Notify.create({
          type: 'negative',
          message: 'User registration failed',
          icon: 'person_add',
        });
      });
  }
  else {
    Notify.create({
      type: 'negative',
      message: 'Password does not match',
      icon: 'person_add',
    });
  }
}
</script>
