<script setup>
import IconClose from '../../icons/IconClose.vue';
import { useStore } from 'vuex';
import { onMounted, ref } from 'vue';

const state = ref('new')
const prop = defineProps(['typePopupDoc', 'idDoc'])

const emit = defineEmits(['closePopup', 'updateTable'])

const store = useStore();

const apiDocNew = store.getters['api/apiDocNew']
const apiDocEdit = store.getters['api/apiDocEdit']

const docObject = ref({
  name: "",
  author: "",
  date: "",
  state: "",
  text: "",
})

const docSaveError = ref('')

function trySaveDoc() {
  let api = ''
  if (prop.typePopupDoc === 'new') api = apiDocNew
  else if (prop.typePopupDoc === 'edit') api = apiDocEdit(prop.idDoc)

  fetch(api, {
    method: 'PUT',
    body: JSON.stringify(docObject.value)
  })
    .then(responce => responce.json())
    .then(data => finalSaveDoc(data))
    .catch(error => finalSaveDoc(error))
}

function finalSaveDoc(data) {
  docSaveError.value = ''
  if (data.success) {
    emit('closePopup')
    emit('updateTable')
    // location.reload()
  } else {
    docSaveError.value = data.message
  }
}

async function getDocument() {
  if (prop.typePopupDoc === 'edit') {
    let documentFromServer
    const api = store.getters['api/apiDocGet'](prop.idDoc)
    await fetch(api)
      .then(responce => responce.json())
      .then(data => documentFromServer = data)
    
    docObject.value.name = documentFromServer.name
    docObject.value.author = documentFromServer.author
    docObject.value.date = documentFromServer.date
    docObject.value.state = documentFromServer.state
    docObject.value.text = documentFromServer.text
    console.log(docObject.value)
  }
}

function convertDateToInputFormat(str_date) {
    if (str_date === '') return '';

    let year = str_date.substr(6, 4);
    let month = str_date.substr(3, 2);
    let day = str_date.substr(0, 2);
    return year + '-' + month + '-' + day;
}

onMounted(() => {
  getDocument()
})

</script>

<template>
  <form id="popup-new-doc" class="popup-window new-doc" v-bind:data-state="state" @submit.prevent="trySaveDoc">

    <button id="btn-close-new-doc" class="btn-close" type="button" @click="$emit('closePopup')">
      <IconClose />
    </button>

    <h2 v-if="typePopupDoc === 'new'">Создание нового документа</h2>
    <h2 v-else-if="typePopupDoc === 'edit'">Редактирование документа</h2>

    <div>
      <label>Название документа</label>
      <input id="doc-name" v-model="docObject.name" />
    </div>

    <div>
      <label>Автор</label>
      <input id="doc-author" v-model="docObject.author" />
    </div>

    <div class="columns">

      <div>
        <label>Дата создания</label>
        <input id="doc-date" type="date" v-model="docObject.date" />
      </div>

      <div>
        <label>Статус</label>
        <div class="doc-states">
          <select id="doc-state" v-model="docObject.state">
            <option value="Новый" selected="selected">Новый</option>
            <option value="Готов">Готов</option>
            <option value="В процессе">В процессе</option>
            <option value="Ожидает подтверждения">Ожидает подтверждения</option>
            <option value="Отклонен">Отклонен</option>
          </select>
        </div>
      </div>

    </div>

    <div>
      <label>Описание</label>
      <textarea id="doc-description" v-model="docObject.text"></textarea>
    </div>

    <label class="input-file">
      <input type="file" />
      <span class="input-file-btn">Прикрепить файл</span>
    </label>

    <button id="btn-save-new-doc" class="btn-submit" type="submit">
      Сохранить
    </button>

    <div class="error-msg">
      <span class="error-text">{{ docSaveError }}</span>
    </div>

  </form>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.new-doc {
  border-radius: 40px;
  top: 5%;
  width: 600px;
  left: calc((100vw - 690px) / 2);

  .btn-submit {
    margin-top: 35px;
    width: 100%;
    padding: 25px;
  }

  .doc-states {
    @include custom-list();
    margin: 8px 0px;

    select {
      margin-bottom: 8px;
      padding: 20px;
    }
  }

  .columns {
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    align-items: center;
  }
}

.input-file {
  width: max-content;
  margin-top: 5px;

  .input-file-btn {
    cursor: pointer;
    display: inline-block;
    color: $dark-blue;
    text-align: center;
    background-color: white;
    padding: 20px;
    border: 3px solid $dark-blue;
    border-radius: 10px;
    margin-top: 5px;
    transition: background-color 0.2s;
    width: 240px;
  }

  /* Focus */
  input[type=file] {
    position: absolute;
    z-index: -1;
    opacity: 0;
    display: block;
    width: 0;
    height: 0;

    &:focus+.input-file-btn {
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }
  }

  /* Hover/active */
  &:hover .input-file-btn {
    background-color: $very-light-blue;
  }

  &:active .input-file-btn {
    background-color: $very-dark-blue;
    border-color: $very-dark-blue;
    color: white;
  }

}

.btn-submit {
  @include blue-button();
  margin: 10px 0 0px 0;
  padding: 22px;
  border-radius: 20px;
  border: none;
  min-width: 250px;
}
</style>