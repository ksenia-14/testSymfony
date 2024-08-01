<script setup>
import { useStore } from 'vuex';
const store = useStore();

const emit = defineEmits(['deleteDoc'])
const props = defineProps(['idSelect'])
const apiDelete = store.getters['api/apiDocDelete']

function deleteDoc() {
  if(props.idSelect === '') return

  let api = apiDelete(props.idSelect)
  fetch(api, {
    method: 'DELETE',
  })
    .then(responce => responce.json())
    .then(data => finalDelete(data))
    .catch(error => finalDelete(error))
}

function finalDelete(data) {
  if(data.success) {
    emit('deleteDoc', props.idSelect)
    location.reload()
  } else {
    console.log(data.message)
  }
}
</script>

<template>
  <button id="btn-delete" @click="deleteDoc">Удалить</button>
</template>