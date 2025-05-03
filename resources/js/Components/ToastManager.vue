<script lang="ts" setup>
import { Toaster, toast } from 'vue-sonner';
import { usePage } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';

interface FlashMessage {
  message?: string | null;
  type?: 'success' | 'error' | 'info' | 'warning';
}

const showToast = (flash: FlashMessage) => {
  if (!flash?.message) return;

  const toastFunctions = {
    success: toast.success,
    error: toast.error,
    info: toast.info,
    warning: toast.warning,
  };

  const toastFunction = flash.type && toastFunctions[flash.type as keyof typeof toastFunctions]
    ? toastFunctions[flash.type as keyof typeof toastFunctions]
    : toast.success;

  toastFunction(flash.message, {
    id: `toast-${Date.now()}`,
  });
};

onMounted(() => {
  const flash =  usePage().props?.flash as FlashMessage;
  showToast(flash);

  // Observar alterações nas props flash para navegação SPA
  watch(
    () => usePage().props?.flash, (newFlash) => {
      showToast(newFlash as FlashMessage);
    }
  );
});
</script>

<template>
  <Toaster
    position="bottom-center"
    :duration="5000"
    richColors
    :closeOnClick="true"
    expand
    :visibleToasts=3
  />
</template>
