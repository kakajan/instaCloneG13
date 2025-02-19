<template>
  <q-page padding>
    <!-- content -->
     <h1>List Of my All Posts</h1>
  </q-page>
</template>

<script setup>
import { api } from 'src/boot/axios';

api.get('api/posts')
  .then((r) => {
    console.log(r.data);
  }).catch((e) => {
    console.log(e);
  });
</script>
