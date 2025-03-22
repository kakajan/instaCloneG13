<template>
  <q-page padding>
    <!-- content -->
    <q-input v-model="post.title" placeholder="Post title" />
    <q-input v-model="post.content" placeholder="Post Content" type="textarea" />
    <q-btn @click="savePost" label="save Post" color="primary" class="full-width" rounded />
  </q-page>
</template>

<script setup>
import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { onMounted, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const router = useRouter();
import { useAppData } from 'src/stores/appData';
const appData = useAppData();
const route = useRoute()
const post = reactive({
  title: null,
  content: null
})
onMounted(() => {
  if (appData.posts.length > 0) {
    post.title= appData.posts[appData.currentPostIndex].title;
    post.content= appData.posts[appData.currentPostIndex].content;
  } else {
    fetchPost()
  }
});
function fetchPost () {
  api.get('api/posts/' + route.params.id)
    .then((r) => {
      post.title = r.data.title;
      post.content = r.data.content;
      console.log(r.data);
    }).catch((e) => {
      console.log(e.status);
      if(e.status === 401) {
        localStorage.removeItem('access_token');
        window.location.href = '/';
      }
      if(e.status === 500) {
        Notify.create({
          type: 'negative',
          message: 'Server error',
          icon: 'error',
        });
      }
    });
}
function savePost () {
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
