<template>
  <q-page padding>
    <!-- content -->
    <q-input v-model="post.title" placeholder="Post title" />
    <q-input v-model="post.content" placeholder="Post Content" type="textarea" />
    <q-btn @click="createPost" label="Create Post" color="primary" class="full-width" rounded />
  </q-page>
</template>

<script setup>
import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
const router= useRouter();
const post = reactive({
  title: null,
  content: null
})
function createPost () {
  api.post('/api/posts', post)
    .then((r) => {
      if (r.data.status) {
        Notify.create({
          type: 'positive',
          message: 'Post created successfully',
          icon: 'person_add',
        });
        router.push('/posts');
      } else {
        Notify.create({
          type: 'negative',
          message: 'Post creation failed',
          icon: 'person_add',
        });
      }
    }).catch((e) => {
      console.log(e);
      Notify.create({
        type: 'negative',
        message: 'Post creation failed',
        icon: 'person_add',
      });
    });
}
</script>
