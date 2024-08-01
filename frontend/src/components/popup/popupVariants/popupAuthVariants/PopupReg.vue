<script setup>
import IconClose from "@/components/icons/IconClose.vue";
import { ref } from 'vue';

const emit = defineEmits(['closePopup', 'tryAuth'])
const prop = defineProps(['regError'])

const login = ref('')
const password = ref('')
const passwordRepeat = ref('')

</script>

<template>
  <form id="popup-reg" class="popup-window auth-form"
    @submit.prevent="$emit('tryAuth', { login: login, password: password, passwordRepeat: passwordRepeat })">
    <button id="btn-close-reg" class="btn-close" type="button" @click="$emit('closePopup')">
      <IconClose />
    </button>
    <h2>Регистрация</h2>
    <span>Логин</span>
    <input v-model="login" />
    <span>Пароль</span>
    <input type="password" autocomplete="on" v-model="password" />
    <span>Подтвердите пароль</span>
    <input type="password" autocomplete="on" v-model="passwordRepeat" />
    <button class="btn-submit" type="submit">Зарегистрироваться</button>
    <div class="error-msg">
      <span class="error-text">{{ regError }}</span>
    </div>
  </form>
</template>