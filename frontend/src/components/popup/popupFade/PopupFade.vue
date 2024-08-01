<script setup>
const emit = defineEmits(['closePopupOnFade'])
</script>

<template>
  <div class="popup-fade" @click="$emit('closePopupOnFade')"></div>
</template>

<style lang="scss" scope>
.popup-fade {
  position: fixed;
  background: rgba(0, 92, 141, 0.257);
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1;
}
</style>