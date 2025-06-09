<script setup lang="ts">
import { Icon } from '@iconify/vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Dropdown from '@/Components/Dropdowns/Dropdown.vue';
import DropdownItem from '@/Components/Dropdowns/DropdownItem.vue';
import Comments from '@/Layouts/CommentsLayout.vue';
import { PostView } from '@/types/Post';
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/Buttons/DangerButton.vue';

interface PostWithComments extends PostView {
  comments: Array<{
    id: number;
    content: string;
    created_at: string;
    user: {
      id: number;
      name: string;
    };
    parent_id: number | null;
  }>;
}

const props = defineProps<{ post: PostWithComments }>();

const confirmingPostDeletion = ref(false);

const confirmPostDeletion = () => {
  confirmingPostDeletion.value = true;
};

const closeModal = () => {
  confirmingPostDeletion.value = false;
};

const deletePost = () => {
  router.delete(route('posts.destroy', props.post.id));
};
</script>

<template>
  <Head :title="props.post.title" />
  <AuthenticatedLayout>
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex flex-col gap-8">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl md:text-5xl font-semibold leading-tight text-gray-800 mt-8">
          {{ props.post.title }}
        </h2>
        <template v-if="($page.props.auth.user) && ($page.props.auth.user.id === props.post.author_id)">
          <!-- Ações do post -->
          <Dropdown align="right" width="48">
            <template #trigger>
              <SecondaryButton class="!p-1" title="Mais ações">
                <Icon icon="ri:more-fill" width="24" height="24" />
              </SecondaryButton>
            </template>
            <template #content>
              <DropdownItem :href="route('posts.edit', [props.post.author, props.post.slug])">
                <Icon icon="ri:edit-2-fill" width="18" height="18" />
                Editar
              </DropdownItem>
              <DropdownItem as="button" @click="confirmPostDeletion" class="text-red-600 hover:bg-red-100">
                <Icon icon="ri:delete-bin-5-line" width="18" height="18" />
                Apagar
              </DropdownItem>
            </template>
          </Dropdown>

          <!-- Modal para confirmar o delete -->
          <Modal :show="confirmingPostDeletion" @close="closeModal">
            <div class="p-6">
              <h2 class="text-lg font-medium text-gray-900">
                Tem certeza que deseja excluir este post?
              </h2>

              <p class="mt-1 text-sm text-gray-600">
                Esta ação não pode ser desfeita. O post "{{ props.post.title }}" será excluído permanentemente.
              </p>

              <div class="mt-6 flex justify-end space-x-3">
                <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                <DangerButton @click="deletePost" class="ml-3">Excluir Post</DangerButton>
              </div>
            </div>
          </Modal>
        </template>
      </div>

      <div class="flex items-center gap-4">
        <div class="bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center text-orange-700">
          {{ props.post.author[0] }}
        </div>
        <div>
          <p class="text-gray-800 font-medium">{{ props.post.author }}</p>
          <p class="text-gray-500 text-sm" :title="`${props.post.day_week_created}, ${props.post.created_at}`">
            Publicado em {{ props.post.created_at }}
          </p>
        </div>
      </div>

      <!-- Categorias do post -->
      <div v-if="props.post.categories && props.post.categories.length > 0" class="flex flex-wrap gap-2 max-w-xl">
        <span
          v-for="category in props.post.categories"
          :key="category.id"
          class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm ring-1 ring-gray-200"
          title="Categorias"
        >
          {{ category.name }}
        </span>
      </div>

      <hr>
      <div v-html="props.post.content" class="post-content"></div>

      <!-- Seção de comentários -->
      <Comments :post-id="props.post.id" :comments="props.post.comments" />
    </section>
  </AuthenticatedLayout>
</template>
