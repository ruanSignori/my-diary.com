
<script>
    import { Editor, EditorContent } from '@tiptap/vue-3'
    import StarterKit from '@tiptap/starter-kit'

    export default {
        components: {
            EditorContent,
        },

        data() {
            return {
                editor: null,
            }
        },

        mounted() {
            this.editor = new Editor({
                content: "<h1>I'm running Tiptap with Vue.js. 🎉</h1>",
                extensions: [StarterKit],
            })
        },

        beforeUnmount() {
            this.editor.destroy()
        },
    }
</script>
<template>
    <editor-content :editor="editor" />
</template>
