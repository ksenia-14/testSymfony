<script setup>
import ButtonDelete from '@/components/pageBlocks/mainBlock/docs/docBtnActions/ButtonDelete.vue';
import ButtonDownload from '@/components/pageBlocks/mainBlock/docs/docBtnActions/ButtonDownload.vue';
import ButtonEdit from '@/components/pageBlocks/mainBlock/docs/docBtnActions/ButtonEdit.vue';
import ButtonSend from '@/components/pageBlocks/mainBlock/docs/docBtnActions/ButtonSend.vue';

const emit = defineEmits(['deleteDoc', 'updateTable'])
const props = defineProps(['idSelect'])
</script>

<template>
  <div class="doc-actions">
    <ButtonSend :id-select="idSelect" @updateTable="$emit('updateTable')" />
    <ButtonEdit :id-select="idSelect" @updateTable="$emit('updateTable')" />
    <ButtonDelete :id-select="idSelect" @updateTable="$emit('updateTable')" @deleteDoc="$emit('deleteDoc', $event)" />
    <ButtonDownload :id-select="idSelect" />
  </div>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.doc-actions {
  display: grid;
  grid-template-columns: repeat(4, max-content);
  gap: 20px;

  button {
    @include blue-button();
    width: 250px;
  }
}
</style>