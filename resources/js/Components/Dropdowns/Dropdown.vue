<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = withDefaults(
  defineProps<{
    align?: 'left' | 'right' | 'center';
    width?: '48';
    contentClasses?: string;
    nested?: boolean;
  }>(),
  {
    align: 'right',
    width: '48',
    contentClasses: 'py-1 bg-bg',
    nested: false,
  },
);

const closeOnEscape = (e: KeyboardEvent) => {
  if (open.value && e.key === 'Escape') {
    open.value = false;
  }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
  return {
    48: 'w-48',
  }[props.width.toString()];
});

const alignmentClasses = computed(() => {
  const stylesAlignment = {
    left: 'ltr:origin-top-left rtl:origin-top-right start-0',
    right: 'ltr:origin-top-right rtl:origin-top-left end-0',
    center: 'ltr:origin-top-center rtl:origin-top-center transform -translate-x-4',
  };

  if (props.align in stylesAlignment) {
    return stylesAlignment[props.align];
  }

  return stylesAlignment.center;
});

const open = ref(false);

// Função para alternar o estado do dropdown
const toggleDropdown = (e: Event) => {
  e.stopPropagation();
  open.value = !open.value;
};
</script>

<template>
  <div class="relative">
    <!-- Trigger do dropdown -->
    <div @click="toggleDropdown">
      <slot name="trigger" />
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div
      v-if="!props.nested"
      v-show="open"
      class="fixed inset-0 z-40"
      @click="open = false"
    ></div>

    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-show="open"
        class="absolute z-50 mt-2 rounded-md shadow-lg"
        :class="[widthClass, alignmentClasses]"
      >
        <div
          class="rounded-md ring-1 ring-bg-dark ring-opacity-5 px-2"
          :class="contentClasses"
        >
          <slot name="content" />
        </div>
      </div>
    </Transition>
  </div>
</template>
