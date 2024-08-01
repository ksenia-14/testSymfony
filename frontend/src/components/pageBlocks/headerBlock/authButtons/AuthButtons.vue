<script setup>
import PopupBlock from '@/components/popup/PopupBlock.vue';

import { onMounted, onUpdated, ref } from 'vue';

const isPopupRegOpen = ref(false)
const isPopupLoginOpen = ref(false)

const tokenExist = ref(isTokenExist('auth_token'))

function isTokenExist(token_name) {
  return localStorage.getItem(token_name) && localStorage.getItem(token_name).length > 0
}

function updateTokenExist(token_name) {
  tokenExist.value = isTokenExist(token_name)
}

function removeToken() {
  console.log('remove token')
  tokenExist.value = false
  localStorage.removeItem('auth_token')
}

function closePopup() {
  isPopupLoginOpen.value = false
  isPopupRegOpen.value = false
  updateTokenExist('auth_token')
}

</script>

<template>
  <li v-if="tokenExist">
    <button class="btn-exit" href="" @click="removeToken">Выход</button>
  </li>

  <li v-if="!tokenExist">
    <button id="btn-open-login" class="button-header" @click="isPopupLoginOpen = true">
      Войти
    </button>
    <Teleport to="body">
      <PopupBlock type-popup="login" v-if="isPopupLoginOpen" @closePopup="closePopup" />
    </Teleport>
  </li>

  <li v-if="!tokenExist">
    <button id="btn-open-reg" class="button-header" @click="isPopupRegOpen = true">
      Зарегистрироваться
    </button>
    <Teleport to="body">
      <PopupBlock type-popup="reg" v-if="isPopupRegOpen" @closePopup="closePopup" />
    </Teleport>
  </li>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

button {
  background-color: white;
  border: 3px solid;
  border-color: white;
  border-radius: 15px;
  padding: 14px;
  margin: 10px;

  color: $dark-blue;
  font-weight: bold;

  &:active {
    background-color: $very-dark-blue;
    border-color: white;
    color: white;
  }
}

.btn-exit {
  background-color: rgb(0, 182, 227);
  color: white;
  padding: 16px;
  margin-right: 40px;
  margin-left: 40px;
}
</style>