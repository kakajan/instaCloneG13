<template>
  <q-page padding>
    <!-- content -->
    <div class="row q-col-gutter-md">
      <div class="col">
        <q-card flat bordered>
          <q-card-section class="flex flex-center">
            <q-btn size="xl" rounded color="primary" icon="list">My Posts</q-btn>
          </q-card-section>
        </q-card>
      </div>
      <div class="col">
        <q-card flat bordered>
          <q-card-section class="flex flex-center">
            <q-btn @click="$router.push('create-post')" size="xl" rounded color="primary" icon="add">Create Post</q-btn>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script setup>
//
</script>
