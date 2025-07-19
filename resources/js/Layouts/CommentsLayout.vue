<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { formatDateToBr } from '@/Helpers/dateHelper';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import Dropdown from '@/Components/Dropdowns/Dropdown.vue';
import DropdownItem from '@/Components/Dropdowns/DropdownItem.vue';
import Modal from '@/Components/Modal.vue';

import { Comment } from '@/types/Comments';

interface User {
  id: number;
  name: string;
}

interface Props {
  postId: number;
  comments: Comment[];
}

interface CommentWithChildren extends Comment {
  children: CommentWithChildren[];
}

const props = defineProps<Props>();
const page = usePage();

const newComment = ref('');
const replyingTo = ref<number | null>(null);
const replyContent = ref('');
const confirmingDeletion = ref<number | null>(null);
const editingComment = ref<number | null>(null);
const editContent = ref('');

// Computed
const user = computed(() => page.props.auth?.user as User | null);

// Função recursiva para organizar comentários
const organizeCommentsRecursively = (comments: Comment[], parentId: number | null = null): CommentWithChildren[] => {
  const filtered = comments.filter(comment => comment.parent_id === parentId);

  return filtered.map(comment => ({
    ...comment,
    children: organizeCommentsRecursively(comments, comment.id)
  }));
};

const organizedComments = computed(() => {
  return organizeCommentsRecursively(props.comments);
});

// Computed reativo para contar apenas comentários não excluídos
const totalCommentsCount = computed(() => {
  return props.comments.filter(comment => !comment.deleted_at).length;
});

const submitComment = () => {
  if (!newComment.value.trim()) return;

  router.post(route('comments.store'), {
    post_id: props.postId,
    content: newComment.value,
  }, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      newComment.value = '';
    }
  });
};

const submitReply = (parentId: number) => {
  if (!replyContent.value.trim()) return;

  router.post(route('comments.store'), {
    post_id: props.postId,
    content: replyContent.value,
    parent_id: parentId,
  }, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: (response) => {
      replyContent.value = '';
      replyingTo.value = null;
    }
  });
};

const startReply = (commentId: number) => {
  replyingTo.value = commentId;
  replyContent.value = '';
};

const cancelReply = () => {
  replyingTo.value = null;
  replyContent.value = '';
};

const startEdit = (comment: Comment) => {
  editingComment.value = comment.id;
  editContent.value = comment.content;
};

const cancelEdit = () => {
  editingComment.value = null;
  editContent.value = '';
};

const updateComment = (commentId: number) => {
  if (!editContent.value.trim()) return;

  router.patch(route('comments.update', commentId), {
    content: editContent.value,
  }, {
    onSuccess: () => {
      editingComment.value = null;
      editContent.value = '';
    }
  });
};

const confirmDelete = (commentId: number) => {
  confirmingDeletion.value = commentId;
};

const deleteComment = () => {
  if (!confirmingDeletion.value) return;

  router.delete(route('comments.destroy', confirmingDeletion.value), {
    onSuccess: () => {
      confirmingDeletion.value = null;
    }
  });
};

const closeDeleteModal = () => {
  confirmingDeletion.value = null;
};

const canModifyComment = (comment: Comment) => {
  return user.value && user.value.id === comment.user.id && !comment.deleted_at;
};

const isCommentDeleted = (comment: Comment) => {
  return comment.deleted_at !== null && comment.deleted_at !== undefined;
};

// Função para renderizar todos os comentários de forma linear com indentação
const flattenComments = (comments: CommentWithChildren[], depth: number = 0): Array<{comment: CommentWithChildren, depth: number}> => {
  const result: Array<{comment: CommentWithChildren, depth: number}> = [];

  for (const comment of comments) {
    result.push({ comment, depth });
    if (comment.children && comment.children.length > 0) {
      result.push(...flattenComments(comment.children, depth + 1));
    }
  }

  return result;
};

const flatComments = computed(() => {
  return flattenComments(organizedComments.value);
});
</script>

<template>
  <div class="mt-12 border-t pt-8">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">
      Comentários ({{ totalCommentsCount }})
    </h3>

    <!-- Formulário para novo comentário -->
    <div v-if="user" class="mb-8">
      <div class="flex gap-3">
        <div class="bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center text-orange-700 flex-shrink-0">
          {{ user.name[0] }}
        </div>
        <div class="flex-1">
          <textarea
            v-model="newComment"
            placeholder="Escreva seu comentário..."
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
          ></textarea>
          <div class="flex justify-end mt-2">
            <PrimaryButton @click="submitComment" :disabled="!newComment.trim()" >
              <Icon icon="ri:send-plane-2-line" width="16" height="16" class="mr-1" />
              Comentar
            </PrimaryButton>
          </div>
        </div>
      </div>
    </div>

    <!-- Lista de comentários organizados -->
    <div class="space-y-4">
      <div
        v-for="{ comment, depth } in flatComments"
        :key="comment.id"
        class="border-l-2 border-gray-100"
        :style="{ marginLeft: `${Math.min(depth, 8) * 1.5}rem` }"
      >
        <!-- Comentário -->
        <div
          class="rounded-lg p-4 border"
          :class="[
            isCommentDeleted(comment)
              ? 'bg-gray-50 border-gray-200 opacity-75'
              : depth % 2 === 0 ? 'bg-white border-gray-200' : 'bg-gray-50 border-gray-200'
          ]"
        >
          <!-- Comentário excluído -->
          <div v-if="isCommentDeleted(comment)">
            <div class="flex items-center gap-2 text-gray-500">
              <Icon icon="ri:delete-bin-line" width="16" height="16" />
              <span class="text-sm italic">Este comentário foi excluído</span>
              <span class="text-xs text-gray-400">{{ formatDateToBr(comment.deleted_at as string) }}</span>
            </div>
          </div>

          <!-- Comentário normal -->
          <div v-else>
            <div class="flex justify-between items-start mb-3">
              <div class="flex items-center gap-3">
                <div
                  class="bg-orange-100 rounded-full flex items-center justify-center text-orange-700 flex-shrink-0"
                  :class="depth === 0 ? 'w-8 h-8 text-sm' : depth <= 2 ? 'w-7 h-7 text-xs' : 'w-6 h-6 text-xs'"
                >
                  {{ comment.user.name[0] }}
                </div>
                <div>
                  <p class="text-sm font-medium bg-primary-lightest text-primary-dark py-0.5 px-1.5 rounded-lg">{{ comment.user.name }}</p>
                  <p class="text-xs text-gray-500">{{ formatDateToBr(comment.created_at) }}</p>
                </div>
              </div>

              <!-- Menu de ações -->
              <div v-if="canModifyComment(comment)">
                <Dropdown align="right">
                  <template #trigger>
                    <button class="p-1 text-gray-400 hover:text-gray-600 rounded">
                      <Icon icon="ri:more-fill" width="16" height="16" />
                    </button>
                  </template>
                  <template #content>
                    <DropdownItem as="button" @click="startEdit(comment)">
                      <Icon icon="ri:edit-2-line" width="16" height="16" />
                      Editar
                    </DropdownItem>
                    <DropdownItem as="button" @click="confirmDelete(comment.id)" class="text-red-600 hover:bg-red-100">
                      <Icon icon="ri:delete-bin-5-line" width="16" height="16" />
                      Excluir
                    </DropdownItem>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Conteúdo do comentário -->
            <div v-if="editingComment === comment.id" class="mb-3">
              <textarea
                v-model="editContent"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
              ></textarea>
              <div class="flex gap-2 mt-2">
                <PrimaryButton @click="updateComment(comment.id)" size="sm">
                  Salvar
                </PrimaryButton>
                <SecondaryButton @click="cancelEdit" size="sm" variant="outline">
                  Cancelar
                </SecondaryButton>
              </div>
            </div>
            <div v-else>
              <p class="text-gray-700 mb-3">{{ comment.content }}</p>
            </div>

            <!-- Botão responder -->
            <div v-if="user && editingComment !== comment.id" class="flex gap-2">
              <button
                @click="startReply(comment.id)"
                class="text-sm text-primary-desaturated hover:text-primary flex items-center gap-1"
              >
                <Icon icon="ri:reply-line" width="14" height="14" />
                Responder
              </button>
            </div>
          </div>
        </div>

        <!-- Formulário de resposta (apenas para comentários não excluídos) -->
        <div v-if="replyingTo === comment.id && !isCommentDeleted(comment)" class="mt-3 ml-6">
          <div class="flex gap-3">
            <div
              class="bg-orange-100 rounded-full flex items-center justify-center text-orange-700 flex-shrink-0"
              :class="depth === 0 ? 'w-8 h-8 text-sm' : depth <= 2 ? 'w-7 h-7 text-xs' : 'w-6 h-6 text-xs'"
            >
              {{ user?.name[0] }}
            </div>
            <div class="flex-1">
              <textarea
                v-model="replyContent"
                placeholder="Escreva sua resposta..."
                rows="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
              ></textarea>
              <div class="flex gap-2 mt-2">
                <PrimaryButton @click="submitReply(comment.id)" size="sm">
                  Responder
                </PrimaryButton>
                <SecondaryButton @click="cancelReply" size="sm" variant="outline">
                  Cancelar
                </SecondaryButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de confirmação de exclusão -->
    <Modal :show="confirmingDeletion !== null" @close="closeDeleteModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
          Confirmar exclusão
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          Tem certeza que deseja excluir este comentário? Esta ação não pode ser desfeita.
        </p>

        <div class="mt-6 flex justify-end space-x-3">
          <SecondaryButton @click="closeDeleteModal">Cancelar</SecondaryButton>
          <DangerButton @click="deleteComment">Excluir</DangerButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
