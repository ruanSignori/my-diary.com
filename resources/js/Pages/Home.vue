<script setup lang="ts">
import HeaderLayout from '@/Layouts/HeaderLayout.vue';
import { PostSimpleView } from '@/types/Post';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{ posts: PostSimpleView[] }>();

</script>

<template>
    <Head title="Home"></Head>
    <HeaderLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Página inicial
        </h2>
      </template>

      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex flex-col gap-6">
      <div v-for="post in posts" :key="post.id">
        <a class="flex items-center gap-4 py-6" :href="route('posts.show', [post.author, post.slug])">
            <div class="bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center text-orange-700">
            {{ post.author.charAt(0) }}
          </div>
          <div>
            <h5 class="text-2xl font-semibold leading-tight text-gray-800">
              {{ post.title }}
            </h5>
            <p class="text-gray-500 text-sm">
             {{ post.author }} • Publicado em {{ post.day_week_created }}, {{ post.created_at }}
            </p>
          </div>
        </a>
        <hr>
      </div>
    </section>
    </HeaderLayout>
</template>
