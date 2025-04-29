<script setup lang="ts">
import { ref, computed, defineProps, defineEmits } from 'vue';
import { Icon } from '@iconify/vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';

interface Option {
  value: string | number | null;
  label: string;
}

const props = defineProps<{
  options: Option[];
  modelValue: (string | number)[];
  placeholder?: string;
}>();

const emit = defineEmits(['update:modelValue', 'create-option']);
const searchInputRef = ref<HTMLInputElement | null>(null);

const isOpen = ref(false);
const searchQuery = ref('');

const colorPalette = {
  bg: 'var(--color-primary-lighter)',
  text: 'var(--color-primary-darker)'
};

const selectedItems = computed(() => {
  return props.options.filter(option => props.modelValue.includes(option.value as string));
});

const filteredOptions = computed(() => {
  if (!searchQuery.value) {
    return props.options;
  }

  const query = searchQuery.value.toLowerCase().trim();
  return props.options.filter(option =>
    option.label.toLowerCase().includes(query)
  );
});

const createOption = () => {
  if (searchQuery.value.trim()) {
    emit('create-option', searchQuery.value.trim());
    searchQuery.value = '';
    isOpen.value = false;
  }
};

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
  if (isOpen.value) {
    setTimeout(() => {
      searchInputRef.value?.focus();
    }, 50);
  }
};

const closeDropdown = () => {
  if (searchQuery.value && !filteredOptions.value.length) {
    // Possibilidade de criar nova opção
    emit('create-option', searchQuery.value);
  }
  isOpen.value = false;
  searchQuery.value = '';
};

const isSelected = (option: Option): boolean => {
  return props.modelValue.includes(option.value as string);
};

const addItem = (option: Option) => {
  const newValue = [...props.modelValue];

  if (isSelected(option)) {
    const index = newValue.indexOf(option.value as string);
    if (index !== -1) {
      newValue.splice(index, 1);
    }
  } else {
    newValue.push(option.value as string);
  }

  emit('update:modelValue', newValue);
};

const removeItem = (option: Option) => {
  const newValue = props.modelValue.filter(val => val !== option.value);
  emit('update:modelValue', newValue);
};

// Diretiva click-outside
const vClickOutside = {
  mounted: (el: any, binding: any) => {
    el.clickOutsideEvent = (event: Event) => {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value();
      }
    };
    document.addEventListener('click', el.clickOutsideEvent);
  },
  unmounted: (el: any) => {
    document.removeEventListener('click', el.clickOutsideEvent);

  }
};
</script>

<template>
  <div class="relative" v-click-outside="closeDropdown">
    <!-- Header do select -->
    <div @click.stop="toggleDropdown"
      class="w-full mt-1 flex flex-wrap min-h-10 items-center p-2 bg-white border border-gray-300 shadow-sm rounded-md cursor-pointer focus:outline-none focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]">
      <!-- Ícone "Lista" à esquerda -->
      <div class="mr-2 text-gray-400" v-if="!selectedItems.length">
        <Icon icon="ri:list-unordered" width="18" height="18" />
      </div>

      <!-- Título ou chips selecionados -->
      <div v-if="selectedItems.length === 0" class="text-gray-500 text-sm">
        {{ placeholder || 'Selecione uma ou mais opções' }}
      </div>
      <div v-else class="flex flex-wrap gap-1">
        <div v-for="item in selectedItems" :key="item.value as string"
          class="flex items-center rounded-md px-2 py-1 text-xs"
          :style="{ backgroundColor: colorPalette.bg, color: colorPalette.text }">
          <span>{{ item.label }}</span>
          <button @click.stop="removeItem(item)" class="ml-1 hover:opacity-75 focus:outline-none">
            <Icon icon="ri:close-line" width="16" height="16" />
          </button>
        </div>
      </div>
    </div>

    <!-- Dropdown menu -->
    <div v-if="isOpen"
      class="absolute z-10 w-full mt-1 bg-white border border-gray-300 shadow-lg rounded-md max-h-60 overflow-auto">
      <div class="sticky top-0 bg-white border-b border-gray-100">
        <input
          type="text"
          ref="searchInputRef"
          v-model="searchQuery"
          placeholder="Selecione uma opção ou crie uma"
          class="w-full p-2 text-sm focus:outline-none border-none"
          @click.stop
        >
      </div>

      <!-- Se não encontrou nenhum opção, permite criar uma-->
      <div
        v-if="filteredOptions.length === 0"
        class="p-2 text-gray-500 text-start text-sm flex items-center gap-2 cursor-pointer hover:bg-gray-100"
        @click.stop="createOption"
      >
        Criar
        <div class="rounded-md px-2 py-1 text-xs"
          :style="{ backgroundColor: colorPalette.bg, color: colorPalette.text }">
          {{ searchQuery }}
        </div>
      </div>

      <!-- Exibe as opções -->
      <div v-else>
        <div v-for="option in filteredOptions" :key="option.value as string" @click.stop="addItem(option)"
          class="p-2 hover:bg-gray-50 cursor-pointer flex items-center gap-2 text-sm group">
          <Checkbox :checked="isSelected(option)" name="selected_category" @click.stop="addItem(option)"
            aria-readonly="true" />

          <!-- Tag com o nome da opção -->
          <div class="rounded-md px-2 py-1 text-xs"
            :style="{ backgroundColor: colorPalette.bg, color: colorPalette.text }">
            {{ option.label }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
