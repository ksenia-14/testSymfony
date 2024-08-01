<script setup>
import IconClose from "@/components/icons/IconClose.vue";
import { ref } from 'vue';

const emit = defineEmits(['closePopup', 'tryAuth'])
const prop = defineProps(['loginError'])

const login = ref('')
const password = ref('')

</script>

<template>
  <form id="popup-login" class="popup-window auth-form"
    @submit.prevent="$emit('tryAuth', { login: login, password: password })">
    <button id="btn-close-login" class="btn-close" type="button" @click="$emit('closePopup')">
      <IconClose />
    </button>
    <h2>Вход</h2>
    <span>Логин</span>
    <input v-model="login" />
    <span>Пароль</span>
    <input type="password" autocomplete="on" v-model="password" />
    <button class="btn-submit" type="submit">Войти</button>
    <div class="error-msg">
      <span v-if="loginError" class="error-text">{{ loginError }}</span>
    </div>
  </form>
</template>