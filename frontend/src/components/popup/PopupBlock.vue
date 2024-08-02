<script setup>
import PopupFade from "@/components/popup/popupFade/PopupFade.vue";
import PopupDoc from "@/components/popup/popupVariants/PopupDoc.vue";
import PopupAuth from "./popupVariants/PopupAuth.vue";

const emit = defineEmits(['closePopup', 'updateTable'])
const props = defineProps(['typePopup', 'error', 'idSelect'])

</script>

<template>
  <PopupFade @closePopupOnFade="$emit('closePopup')" />

  <PopupAuth v-if="typePopup === 'login' || typePopup === 'reg'" :type-popup="typePopup"
    @closePopup="$emit('closePopup')" />

  <PopupDoc v-if="typePopup === 'doc-new'" type-popup-doc="new" :doc-error="error" @closePopup="$emit('closePopup')" 
    @updateTable="$emit('updateTable')" />

  <PopupDoc v-if="typePopup === 'doc-edit'" type-popup-doc="edit" :id-doc="props.idSelect" @closePopup="$emit('closePopup')"
    @updateTable="$emit('updateTable')" />
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.popup-window {
  position: absolute;
  z-index: 2;

  display: grid;

  height: min-content;
  padding: 20px 40px 0px 40px;
  background: #FFF;
  border: 8px solid white;
  box-shadow: 0 0 30px $dark-blue;

  h2 {
    margin: 0px 0 35px 0;
  }

  div {
    display: grid;
  }

  label {
    font-weight: bold;
  }

  input,
  textarea {
    margin: 8px 0 15px 0;
  }

  textarea {
    height: 70px;
  }
}

.auth-form {
  border-radius: 40px;
  top: 15%;
  width: 500px;
  left: calc((100vw - 620px) / 2);

  .btn-submit {
    margin-top: 30px;
    min-width: max-content;
    width: 50%;
  }
}

.btn-close {
  background-color: white;
  border: none;
  width: 20px;
  height: 20px;
  justify-self: end;
}

.icon-close {
  cursor: pointer;
  fill: $dark-blue;
  height: 20px;
  width: 20px;
}

.error-msg {
  color: rgb(218, 0, 0);
  padding-top: 15px;
  min-height: 36px;
}
</style>
