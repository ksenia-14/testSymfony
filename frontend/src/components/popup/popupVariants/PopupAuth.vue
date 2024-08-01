<script setup>
import { ref } from 'vue';
import PopupLogin from './popupAuthVariants/PopupLogin.vue';
import PopupReg from './popupAuthVariants/PopupReg.vue';
import { useStore } from 'vuex';

const store = useStore();
const apiAuth = store.getters['api/apiAuth']
const apiRegister = store.getters['api/apiRegister']

const props = defineProps(['typePopup'])
const emit = defineEmits(['closePopup', 'tryAuth'])

const loginError = ref('')

const tokenExist = ref(isTokenExist('auth_token'))

function tryReg(data) {
  if (data.password === data.passwordRepeat) {
    tryAuth(data.login, data.password, apiRegister)
  } else {
    loginError.value = 'Пароли не совпадают'
  }
}

function tryLogin(data) {
  tryAuth(data.login, data.password, apiAuth)
}

async function tryAuth(login, password, api) {
  if (!(login && password)) {
    loginError.value = 'Необходимо заполнить все поля'
    return
  }

  // fetch('../fakeapi/auth_error.json', {
  fetch(api, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      login: login,
      password: password
    })
  })
    .then(responce => responce.json())
    .then(data => finalAuth(data))
    .catch(error => finalAuth(error))
}

function finalAuth(data) {
  loginError.value = ''
  if (data.success) {
    setToken(data.token)
    emit('closePopup')
  } else {
    loginError.value = data.message
  }
}

function isTokenExist(token_name) {
  return localStorage.getItem(token_name) && localStorage.getItem(token_name).length > 0
}

function setToken(token) {
  console.log('set token:', token)
  tokenExist.value = true
  localStorage.setItem('auth_token', token)
}

</script>

<template>
  <PopupLogin v-if="typePopup === 'login'" :login-error="loginError" @closePopup="$emit('closePopup')"
    @tryAuth="tryLogin" />

  <PopupReg v-else-if="typePopup === 'reg'" :reg-error="loginError" @closePopup="$emit('closePopup')"
    @tryAuth="tryReg" />
</template>