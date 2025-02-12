<template>
  <q-page padding class="flex flex-center">
    <!-- content -->
    <div class="q-gutter-y-md text-center">
      <h1 class=" q-mt-lg q-my-none text-h5 text-weight-bolder text-grey-9">Register form</h1>
      <div class="row q-col-gutter-sm">
        <div class="col-6">
          <q-input rounded outlined v-model="name" label="Name" />
        </div>
        <div class="col-6">
          <q-input rounded outlined v-model="email" label="Email" />
        </div>
        <div class="col-6">
          <q-input rounded outlined v-model="password" label="Password" />
        </div>
        <div class="col-6">
          <q-input rounded outlined v-model="confirmPassword" label="Confirm Password" />
        </div>
      </div>
      <q-btn icon="person_add" label="register" color="primary" rounded />
    </div>
  </q-page>
</template>

<script setup>
//
</script>
