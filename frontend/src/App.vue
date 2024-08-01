<script setup>
import { RouterLink, RouterView } from 'vue-router'

import HeaderBlock from "@/components/pageBlocks/headerBlock/HeaderBlock.vue";
import FooterBlock from "@/components/pageBlocks/footerBlock/FooterBlock.vue";

</script>

<template>
  <body>
    <HeaderBlock />
    <RouterView />
    <FooterBlock />
  </body>

</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

*,
*::after,
*::before {
  padding: 0;
  margin: 0;
}

body {
  margin: 0;
  font-family: 'Helvetica', Arial, sans-serif;
  font-size: $main-font-size;

  display: grid;
  grid-template-rows: max-content 1fr max-content;
  min-height: 100vh;

  ::-webkit-calendar-picker-indicator {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="rgb(10, 137, 175)" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
  }
}

header {
  background-color: $main-blue;
  color: white;

  a {
    color: white;
  }
}

a {
  text-decoration: none;
}

button {
  cursor: pointer;
  font-size: $main-font-size;
  font-weight: bold;
}

input:where(:not([type="radio"])),
textarea {
  border-color: $light-blue;
  border-width: 3px;
  border-radius: 20px;
  border-style: solid;
  color: $dark-blue;

  padding: 18px;
  font-size: $main-font-size;

  &:focus {
    outline: none;
    box-shadow: 0 0 10px $main-blue;
  }

  &::placeholder {
    color: $light-blue;
  }
}

textarea {
  resize: none;
}

ul {
  list-style-type: none;
}

select {
  color: $dark-blue;
  font-size: $main-font-size;
}

select:focus {
  outline: none;
}

footer {
  background-color: $main-blue;
  color: white;
  text-align: right;
  padding: 10px;
  font-weight: bold;
}

::-webkit-scrollbar {
  width: 15px;
  height: 15px;
}

::-webkit-scrollbar-button:start:decrement,
::-webkit-scrollbar-button:end:increment {
  height: 10px;
  background-color: transparent;
}

::-webkit-scrollbar-track-piece {
  background-color: white;
  -webkit-border-radius: 16px;
}

::-webkit-scrollbar-thumb:vertical,
::-webkit-scrollbar-thumb:horizontal {
  height: 10px;
  background-color: $very-light-blue;
  border: 2px solid $light-blue;
  -webkit-border-radius: 16px;
}

</style>
