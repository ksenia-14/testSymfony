<script setup>
import PopupBlock from '@/components/popup/PopupBlock.vue';
import { ref } from 'vue';

const props = defineProps(['idSelect'])

const isPopupDocOpen = ref(false)

function btnClick() {
  if (props.idSelect !== '') {
    isPopupDocOpen.value = true
  }
}
</script>

<template>
  <button id="btn-edit" @click="btnClick">Редактировать</button>

  <Teleport to="body">
    <PopupBlock type-popup="doc-edit" :id-select="props.idSelect" v-if="isPopupDocOpen" @closePopup="isPopupDocOpen = false" />
  </Teleport>
</template>