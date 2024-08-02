<script setup>
import PopupBlock from '@/components/popup/PopupBlock.vue';

import { ref } from 'vue';

const emit = defineEmits(['updateTable'])

const isPopupDocOpen = ref(false)
</script>

<template>
  <button id="btn-open-new-doc" class="btn-new-doc" @click="isPopupDocOpen = true">
    Создать новый документ
  </button>
  <Teleport to="body">
    <PopupBlock type-popup="doc-new" v-if="isPopupDocOpen" @closePopup="isPopupDocOpen = false"
      @updateTable="$emit('updateTable')" />
  </Teleport>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.btn-new-doc {
  grid-column-start: 2;
  grid-column-end: 3;
  grid-row-start: 2;
  grid-row-end: 3;
  align-self: self-end;
}
</style>