<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/HeaderLayout.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import InputError from '@/Components/Inputs/InputError.vue';
import InputLabel from '@/Components/Inputs/InputLabel.vue';
import RichTextEditor from '@/Components/Inputs/RichTextEditor.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { getCsrfToken } from '@/Helpers/getCsrfToken';
import MultiSelect from '@/Components/Inputs/MultiSelect.vue';

type PostData = {
  postTitleInput: string;
  postCategoryInput: string[];
  postContent: string;
};

const props = defineProps<{
  categories: {
    value: string | number;
    label: string;
  }[];
}>();

const postTitleInput = ref<HTMLInputElement | null>(null);

const form = useForm<PostData>({
    postTitleInput: '',
    postCategoryInput: [''],
    postContent: ''
});

const handleSubmit = async () => {
  await getCsrfToken();
  const data: PostData = form.data();

  try {
    const response = await axios.post('/posts', data, { maxRedirects: 1});
    window.location.href = response.request.responseURL;
  } catch (error) {
    console.error(error);
  }
}

</script>

<template>
  <Head title="Novo post" />

  <AuthenticatedLayout>
    <template #header>
        <h2
            class="text-xl font-semibold leading-tight text-gray-800"
        >
            Criar nova postagem
        </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <p class="mt-1 text-sm text-gray-600">
            Os campos marcados com um asterisco (*) são obrigatórios.
          </p>
          <section>
            <form @submit.prevent="handleSubmit" class="space-y-6 mt-6">
              <div class="max-w-xl">
                <InputLabel
                  for="postTitle"
                  value="Título do Post"
                  :input-required="true"
                />

                <TextInput
                    id="postTitle"
                    ref="postTitleInput"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="post-title"
                    required
                    autofocus
                    v-model="form.postTitleInput"
                />

                <InputError
                    class="mt-2"
                />
              </div>

              <div class="max-w-sm">

                <InputLabel
                  for="postCategory"
                  value="Categoria"
                  :input-required="true"
                />

                <MultiSelect
                  id="postCategory"
                  :options="props.categories"
                  v-model="form.postCategoryInput"
                  placeholder="Selecionar categorias"
                  label="Selecionar categorias"
                />

              </div>

              <div class="max-w-full">
                <InputLabel
                  for="postContent"
                  value="Conteúdo do Post"
                  :input-required="true"
                />

                <RichTextEditor
                  class="mt-1 "
                  id="postContent"
                  v-model="form.postContent"
                />
              </div>

              <PrimaryButton type="submit">
                Salvar
              </PrimaryButton>
            </form>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
