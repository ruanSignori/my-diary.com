<script setup lang="ts">
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import InputError from '@/Components/Inputs/InputError.vue';
import InputLabel from '@/Components/Inputs/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Deletar minha conta
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Uma vez que sua conta é deletada, todos os seus recursos e dados
                serão permanentemente deletados. Antes de deletar sua conta,
                faça o download de qualquer dado ou informação que você deseja
                reter.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Deletar conta</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900"
                >
                    Você tem certeza que deseja deletar sua conta?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Uma vez que sua conta é deletada, todos os seus recursos e
                    dados serão permanentemente deletados. Você não poderá
                    recuperar sua conta ou qualquer dado ou informação que você
                    armazenou. Por favor, faça o download de qualquer dado ou
                    informação que você deseja reter antes de deletar sua conta.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Sua senha"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Senha"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Deletar conta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
