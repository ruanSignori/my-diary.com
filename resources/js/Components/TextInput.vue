<script setup lang="ts">
import { onMounted, ref } from 'vue';

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        class="rounded-md border-gray-300 shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] dark:border-zinc-700 dark:bg-bg-desaturated dark:text-gray-300 dark:focus:border-[var(--color-primary)] dark:focus:ring-[var(--color-primary)]"
        v-model="model"
        ref="input"
    />
</template>
