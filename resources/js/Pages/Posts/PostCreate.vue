<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import InputError from '@/Components/Inputs/InputError.vue';
import InputLabel from '@/Components/Inputs/InputLabel.vue';
import RichTextEditor from '@/Components/Inputs/RichTextEditor.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { ref, defineProps, watch } from 'vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import MultiSelect from '@/Components/Inputs/MultiSelect.vue';

type PostData = {
  postTitleInput: string;
  existingCategories: number[];  // Categorias existentes (IDs)
  newCategories: string[];       // Novas categorias (labels)
  postContent: string;
};

const props = defineProps<{
  categories: {
    value: string | number;
    label: string;
  }[];
}>();

const postTitleInput = ref<HTMLInputElement | null>(null);

const selectedCategories = ref<(string | number)[]>([]); // Categorias selecionadas (mix de IDs e strings)
const newCategories = ref<string[]>([]); // Categorias inseridas pelo usuário (client-side)

const localCategories = ref([...props.categories]); // Categorias disponíveis para seleção

const form = useForm<PostData>({
  postTitleInput: '',
  existingCategories: [],
  newCategories: [],
  postContent: ''
});

// Manipula o processamento de seleção de categorias
watch(selectedCategories, (newVal) => {
  const existingCats: number[] = [];
  const newCats: string[] = [];

  newVal.forEach(category => {
    if (typeof category === 'number') {
      existingCats.push(category);
    }

    if (typeof category === 'string') {
      const numValue = Number(category);

      if (!isNaN(numValue) && String(numValue) === category) {
        existingCats.push(numValue);
      } else {
        newCats.push(category);
      }
    }
  });

  // Atualiza o estado do formulário diretamente
  form.existingCategories = existingCats;
  form.newCategories = newCats;
});

const createOption = (label: string) => {
  localCategories.value.push({
    value: label,
    label: label
  });

  selectedCategories.value.push(label);

  if (!form.newCategories.includes(label)) {
    form.newCategories.push(label);
  }
};

const handleSubmit = () => {
  form.post(route('posts.store'));
};

</script>

<template>
  <Head title="Novo post" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
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
                <InputError class="mt-2" :message="form.errors.postTitleInput" />
              </div>
              <div class="max-w-sm">
                <InputLabel
                  for="postCategory"
                  value="Categoria"
                  :input-required="true"
                />
                <MultiSelect
                  id="postCategory"
                  :options="localCategories"
                  v-model="selectedCategories"
                  placeholder="Selecionar categorias"
                  label="Selecionar categorias"
                  @create-option="createOption"
                />
                <InputError class="mt-2" :message="form.errors.existingCategories" />
              </div>
              <div class="max-w-full">
                <InputLabel
                  for="postContent"
                  value="Conteúdo do Post"
                  :input-required="true"
                />
                <RichTextEditor
                  class="mt-1"
                  id="postContent"
                  v-model="form.postContent"
                />
                <InputError class="mt-2" :message="form.errors.postContent" />
              </div>
              <PrimaryButton type="submit" :disabled="form.processing">

              <span v-if="form.processing">
                Enviando...
              </span>
              <span v-else>
                Criar Post
              </span>

              </PrimaryButton>
            </form>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
