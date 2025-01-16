<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

const { auth } = usePage().props;
</script>

<template>
    <Head title="Dashboard"></Head>

    <component :is="auth.user ? AuthenticatedLayout : GuestLayout" />
</template>
