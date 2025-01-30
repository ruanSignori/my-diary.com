<script setup lang="ts">
defineProps<{
    value?: string;
    inputRequired?: boolean;
}>();
</script>

<template>
    <label class="block text-sm font-medium text-gray-700">
        <span v-if="value">
          {{ value }}
          <span v-if="inputRequired" class="text-red-500">*</span>
        </span>
        <span v-else><slot /></span>
    </label>
</template>
