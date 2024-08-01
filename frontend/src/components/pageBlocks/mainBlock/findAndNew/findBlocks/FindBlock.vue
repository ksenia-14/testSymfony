<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
const store = useStore();

const emit = defineEmits(['updateListDocs'])

const apiDocsSearch = store.getters['api/apiDocsSearch']
const documents = ref([])

const findField = ref('')

async function findDocs() {
  await fetch(apiDocsSearch + '?find=' + findField.value)
    .then(responce => responce.json())
    .then(data => documents.value = data)
  emit('updateListDocs', documents.value)
}
</script>

<template>
  <div class="block-find">
    <input id="input-find" class="filter-input" placeholder="Поиск документа" v-model="findField" />
    <button id="btn-find" class="filter-btn" @click="findDocs">Поиск</button>
  </div>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.block-find {
  grid-column-start: 1;
  grid-column-end: 2;
  display: grid;
  grid-template-columns: max-content max-content;
  gap: 10px;

  input {
    align-self: center;
    padding: 20px;
  }
}
</style>