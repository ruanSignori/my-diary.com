<script setup lang="ts">
import { ref, watch, defineProps, defineEmits } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';

// @ts-ignore
import MarkdownShortcuts from 'quill-markdown-shortcuts';
import BlotFormatter from 'quill-blot-formatter'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps<{
  modelValue: string;
}>();

const emit = defineEmits(['update:modelValue']);

const content = ref(props.modelValue);

const updateContent = (quillContent: string) => {
  content.value = quillContent;
  emit('update:modelValue', quillContent);
};

const modules = [
  {
    name: 'blotFormatter',
    module: BlotFormatter
  },
  {
    name: 'markdownShortcuts',
    module: MarkdownShortcuts
  }
];
</script>

<template>
  <div>
    <QuillEditor
      class="!rounded-md !rounded-t-none border-gray-300 shadow-sm"
      :content="content"
      @update:content="updateContent"
      theme="snow"
      content-type="html"
      toolbar="#my-toolbar"
      placeholder="Digite algo..."
      :modules="modules">
      <template #toolbar>
        <div id="my-toolbar" class="rounded-md rounded-b-none bg-bg shadow-sm p-2 ">
          <!-- Headers -->
          <select class="ql-header" title="Título">
            <option selected></option>
            <option value="1">Header 1</option>
            <option value="2">Header 2</option>
            <option value="3">Header 3</option>
          </select>

          <!-- Bold, Italic, Underline -->
          <button class="ql-bold" title="Negrito"></button>
          <button class="ql-italic" title="Itálico"></button>
          <button class="ql-underline" title="Sublinhado"></button>

          <!-- Blockquote (Citação) -->
          <button class="ql-blockquote" title="Citação"></button>

          <!-- Listas -->
          <button class="ql-list" value="ordered" title="Lista ordenada"></button>
          <button class="ql-list" value="bullet" title="Lista não ordenada"></button>
        </div>
      </template>
    </QuillEditor>
  </div>
</template>

<style>
.ql-editor {
  min-height: 300px;
}
</style>
