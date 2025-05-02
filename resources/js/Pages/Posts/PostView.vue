<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PostView } from '@/types/Post';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{ post: PostView }>();
</script>

<template>
  <Head :title="props.post.title"  />

  <AuthenticatedLayout>
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex flex-col gap-8">
      <h2 class="text-5xl font-semibold leading-tight text-gray-800 mt-8">
        {{ props.post.title }}
      </h2>

      <div class="flex items-center gap-4">
        <div class="bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center text-orange-700">
          {{ props.post.author[0] }}
        </div>
        <div>
          <p class="text-gray-800 font-medium">{{ props.post.author }}</p>
          <p class="text-gray-500 text-sm" :title="`${props.post.day_week_created}, ${props.post.created_at}`">
            Publicado em {{ props.post.created_at }}
          </p>
        </div>
      </div>

      <hr>

      <div v-html="props.post.content" class="post-content"></div>
    </section>
  </AuthenticatedLayout>
</template>
