<script setup lang="ts">
import HeaderLayout from '@/Layouts/HeaderLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Home"></Head>
    <HeaderLayout>
      <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Página inicial
            </h2>
      </template>
    </HeaderLayout>
</template>
