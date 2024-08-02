<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
const store = useStore();

const emit = defineEmits(['updateListDocs'])

const apiDocsFilter = store.getters['api/apiDocsFilter']
const documents = ref([])

const docDateWithoutFormat = ref('')

const docObject = ref({
  name: "",
  author: "",
  date: "",
  state: "",
  text: "",
})

function convertDateFromInputFormat(str_date) {
    if (str_date === '') return '';

    let day = str_date.substr(8, 2);
    let month = str_date.substr(5, 2);
    let year = str_date.substr(0, 4);
    return  day + '.' + month + '.' + year;
}

async function filterDocs() {
  docObject.value.date = convertDateFromInputFormat(docDateWithoutFormat.value)
  const params = new URLSearchParams(docObject.value).toString()
  await fetch(apiDocsFilter + '?' + params)
    .then(responce => responce.json())
    .then(data => documents.value = data)
  emit('updateListDocs', documents.value)
}

</script>

<template>
  <div class="filter-menu">
    <div class="header-filters">
      Фильтры:
    </div>
    <div class="filter-items">
      <input id="input-find-by-name" placeholder="Название" v-model="docObject.name" />
      <input id="input-find-by-author" placeholder="Автор" v-model="docObject.author" />
      <input id="input-find-by-date" type="date" v-model="docDateWithoutFormat" />
      <form class="filter-states">
        <select id="input-find-by-state" v-model="docObject.state">
          <option value="" selected>Все статусы</option>
          <option value="Готов">Готов</option>
          <option value="В процессе">В процессе</option>
          <option value="Ожидает подтверждения">Ожидает подтверждения</option>
          <option value="Отклонен">Отклонен</option>
          <option value="Новый">Новый</option>
        </select>
      </form>
      <input id="input-find-by-description" placeholder="Описание" v-model="docObject.description" />
      <button id="btn-apply-filters" class="btn-apply" @click="filterDocs">
        Применить фильтры
      </button>
    </div>
  </div>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.filter-menu {
  grid-column-start: 1;
  grid-column-end: 2;
  grid-row-start: 2;
  grid-row-end: 3;

  .header-filters {
    display: block;
    margin: 9px 0px 9px 0px;
    font-weight: bolder;
  }

  .filter-items {
    display: grid;
    grid-template-columns: repeat(5, max-content);
    gap: 10px;
    margin-top: 10px;
    margin-bottom: 10px;

    .filter-states {
      @include custom-list();
    }
  }

  @media (max-width: $width-media-1) {
    .filter-items {
      grid-template-columns: repeat(4, max-content);
    }

    button {
      grid-row-start: 3;
      grid-row-end: 4;
      align-self: self-end;
      margin-left: 0;
    }
  }

  @media (max-width: $width-media-2) {
    .filter-items {
      grid-template-columns: repeat(3, max-content);
    }
  }
}
</style>