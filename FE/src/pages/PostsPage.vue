<template>
  <q-page padding>
    <!-- content -->
     <q-inner-loading v-if="!me" size="45px" color="primary" label="Loading" />
     <div v-if="me">
      <h1>List Of my All Posts</h1>
     <img :src="me.profile.avatar" alt="">
     {{ me.profile.full_name }}
     </div>

  </q-page>
</template>

<script setup>
import { api } from 'src/boot/axios';
import { onMounted, ref } from 'vue';
const me = ref(null);
onMounted(() => {
  fetchMe();
});
function fetchMe() {
  api.get('api/posts')
    .then((r) => {
      me.value = r.data;
      console.log(r.data);
    }).catch((e) => {
      console.log(e);
    });
}
</script>
