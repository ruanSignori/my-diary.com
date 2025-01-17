<script setup>
import { ref, watchEffect } from 'vue';
import { Icon } from '@iconify/vue';

const isDark = ref(localStorage.getItem('theme') === 'dark' || false);

const toggleTheme = () => {
  if (isDark.value) {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  }
};

watchEffect(() => {
  toggleTheme();
});
</script>

<template>
  <div :class="themeClass" >
    <div class="flex items-center justify-center">
      <!-- Switch de Tema -->
      <label for="theme-toggle" class="flex items-center cursor-pointer">
        <Icon
          :icon="isDark ? 'ph:moon' : 'ph:sun'"
          class="text-xl"
          :class="{
            'text-gray-800': !isDark,
            'text-gray-200': isDark
          }"
        />

      </label>
      <input
            id="theme-toggle"
            type="checkbox"
            v-model="isDark"
            @change="toggleTheme"
            class="hidden"
          />
    </div>
  </div>
</template>
