<script setup>
import PopupBlock from '@/components/popup/PopupBlock.vue';

import { onMounted, ref } from 'vue';

const isPopupDocOpen = ref(false)
</script>

<template>
  <button id="btn-open-new-doc" class="btn-new-doc" @click="isPopupDocOpen = true">
    Создать новый документ
  </button>
  <Teleport to="body">
    <PopupBlock type-popup="doc-new" v-if="isPopupDocOpen" @closePopup="isPopupDocOpen = false" />
  </Teleport>
</template>

<style lang="scss" scope>
.btn-new-doc {
  grid-column-start: 2;
  grid-column-end: 3;
  grid-row-start: 2;
  grid-row-end: 3;
  align-self: self-end;
}
</style>