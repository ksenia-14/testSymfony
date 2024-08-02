<script setup>
import FindBlock from '@/components/pageBlocks/mainBlock/findAndNew/findBlocks/FindBlock.vue'
import FilterBlock from '@/components/pageBlocks/mainBlock/findAndNew/findBlocks/FilterBlock.vue'
import ButtonNewDoc from '@/components/pageBlocks/mainBlock/findAndNew/buttonNewDoc/ButtonNewDoc.vue'

const emit = defineEmits(['updateListDocs', 'updateTable'])
</script>

<template>
  <div id="doc-menu" class="doc-menu">
    <FindBlock @updateListDocs="$emit('updateListDocs', $event)" />
    <FilterBlock @updateListDocs="$emit('updateListDocs', $event)" />
    <ButtonNewDoc @updateTable="$emit('updateTable')" />
  </div>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.doc-menu {
  display: grid;
  grid-template-columns: 1fr max-content;
  grid-template-rows: repeat(2, max-content);
  gap: 10px;
  margin-bottom: 20px;

  button {
    @include blue-button();
  }
}
</style>