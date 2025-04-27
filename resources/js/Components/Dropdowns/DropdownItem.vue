<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    href?: string;
}>();
</script>

<template>
  <template v-if="typeof href === 'string'">
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-bg-darker focus:bg-gray-100 focus:outline-none"
    >
        <slot />
    </Link>
  </template>
  <template v-else>
    <div class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-bg-darker focus:bg-gray-100 focus:outline-none">
      <slot />
    </div>
  </template>
</template>
