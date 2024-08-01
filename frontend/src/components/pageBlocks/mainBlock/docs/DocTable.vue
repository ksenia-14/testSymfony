<script setup>
import DocItem from '@/components/pageBlocks/mainBlock/docs/docItem/DocItem.vue';
import { onMounted, ref, watch } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const prop = defineProps(['documents'])
const emit = defineEmits(['idSelect', 'unselect'])

const needResetRadio = ref(false)
const documents = ref([])

function getDocuments() {
  const api = store.getters['api/apiDocsList']
  fetch(api)
    .then(responce => responce.json())
    .then(data => documents.value = data)
}

watch(
  () => prop.documents,
  () => {
    documents.value = prop.documents
    console.log('doc table updated')
    console.log(documents.value)
    needResetRadio.value = true
    emit('unselect')
  })

onMounted(() => {
  getDocuments()
})

</script>

<template>
  <div id="doc-table" class="doc-table">
    <div class="doc-header">
      <div></div>
      <div><span>Название документа</span></div>
      <div><span>Автор</span></div>
      <div><span>Дата создания</span></div>
      <div><span>Статус</span></div>
      <div><span>Описание</span></div>
    </div>

    <DocItem v-if="documents" v-for="doc in documents" :id="doc.id" :name="doc.name" :author="doc.author"
      :date="doc.date" :state="doc.state" :description="doc.text" :needResetRadio="needResetRadio" 
      @idSelect="$emit('idSelect', $event)" @radioIsReseted="needResetRadio = false" />

  </div>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.doc-table {
  margin-top: 20px;
  margin-bottom: 20px;
}

.doc-header {
  @include doc-grid();

  div {
    background-color: $very-light-blue;
    height: 40px;
    padding: 20px;
    text-align: center;
    display: grid;

    span {
      justify-self: center;
      align-self: center;
    }
  }
}
</style>