<script setup>
import IconHome from '@/components/icons/IconHome.vue'
import AuthButtons from './authButtons/AuthButtons.vue';
</script>

<template>
  <header>
    <nav>
      <ul class="header-menu">
        <li>
          <a class="title-main-page" href="">
            <IconHome />
            ЭДО
          </a>
        </li>
        <li>
          <a class="items-header" href="">Список документов</a>
        </li>
        <li>
          <a class="items-header" href="">Поиск и фильтрация</a>
        </li>
        <li>
          <a class="items-header" href="">Отправка документов</a>
        </li>
        <li>
          <a class="items-header" href="">Настройки</a>
        </li>

        <AuthButtons />
      </ul>
    </nav>
  </header>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.header-menu {
  display: grid;
  grid-template-columns: 1fr repeat(4, 1fr) min-content min-content min-content;
  gap: 5px;
  align-items: center;
  top: 0%;
  font-weight: bold;
  min-height: 80px;
  text-align: center;

  .title-main-page {
    font-size: 34px;
    margin-left: 40px;
    margin-right: 40px;

    display: grid;
    grid-template-columns: repeat(2, max-content);

    svg {
      fill: white;
      height: 34px;
      margin-right: 10px;
    }
  }
}
</style>
