<script setup lang="ts">
withDefaults(
    defineProps<{
        type?: 'button' | 'submit' | 'reset';
    }>(),
    {
        type: 'button',
    },
);
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center rounded-md border border-gray-300 bg-white py-2 px-3 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-light)] focus:ring-offset-2 disabled:opacity-25"
    >
        <slot />
    </button>
</template>


