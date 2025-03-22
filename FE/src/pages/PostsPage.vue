<template>
  <q-page padding>
    <!-- content -->
    <q-inner-loading v-if="!posts" size="45px" color="primary" label="Loading" />
    <div v-else class="row q-col-gutter-md">
      <div class="col-4" v-for="(post, index) in posts" :key="'post' + index">
        <q-card>
          <q-card-section>
            <h3>{{ post.title }}</h3>
          </q-card-section>
          <q-card-section>
            <p>{{ post.content }}</p>
          </q-card-section>
          <q-card-actions align="around">
            <q-btn @click="appData.currentPostIndex = index; $router.push('edit-post/' + post.id)" size="md" rounded color="primary" icon="edit">Edit</q-btn>
            <q-btn @click="$router.push('post/' + post.id)" size="md" rounded color="primary" icon="delete">Delete</q-btn>
          </q-card-actions>
        </q-card>
      </div>
    </div>

  </q-page>
</template>

<script setup>
import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { useAppData } from 'src/stores/appData';
import { onMounted, ref } from 'vue';
const posts = ref(null);
const appData = useAppData();
onMounted(() => {
  fetchPosts();
});
function fetchPosts () {
  api.get('api/posts')
    .then((r) => {
      posts.value = r.data;
      appData.posts = r.data
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
</script>
