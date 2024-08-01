<script setup>
import FindAndNewMenu from "@/components/pageBlocks/mainBlock/findAndNew/FindAndNewMenu.vue";
import DocTable from "@/components/pageBlocks/mainBlock/docs/DocTable.vue";
import DocBtnActionsBlock from '@/components/pageBlocks/mainBlock/docs/DocBtnActionsBlock.vue';
import { ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const displayDoc = ref('all')
const idSelectDoc = ref('')
const documents = ref([])

function updateListDocs(data) {
  documents.value = data
}

function setIdSelect(id) {
  console.log('select id: ', id)
  idSelectDoc.value = id
}

function deleteDoc(id) {
  console.log('delete id: ', id)
  displayDoc.value = displayDoc
  // const api = store.getters['api/apiDocsList']
  const api = store.getters['api/apiDocsSearch']
  fetch(api)
    .then(responce => responce.json())
    .then(data => documents.value = data)
}

</script>

<template>
  <main class="main-page">
    <h2>Список документов</h2>
    <FindAndNewMenu @updateListDocs="updateListDocs" />

    <DocTable :documents="documents" @idSelect="setIdSelect" @unselect="idSelectDoc = ''" />
    
    <DocBtnActionsBlock :id-select="idSelectDoc" @deleteDoc="deleteDoc" />
  </main>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.main-page {
  color: $dark-blue;
  padding: 30px;

  h2 {
    margin-top: 10px;
    margin-bottom: 20px;
  }
}
</style>