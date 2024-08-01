<script setup>
import { onUpdated, ref, watch } from 'vue';

const props = defineProps(['id', 'name', 'author', 'date', 'state', 'description', 'needResetRadio'])
const emit = defineEmits(['idSelect', 'radioIsReseted'])

const isCheked = ref(false)

function onChange() {
  console.log('onChange id: ', props.id)
  isCheked.value = true
  emit('idSelect', props.id)
}

watch(
  () => props.needResetRadio,
  () => {
    if (props.needResetRadio) isCheked.value = false
    emit('radioIsReseted')
  }
)

</script>

<template>
  <div id="doc-1" class="doc-element">
    <div class="center radio-doc">
      <input type="radio" name="radio-doc" :value="id" :checked="isCheked" @click="onChange" />
    </div>
    <div><span class="doc-name"> {{ name }}</span></div>
    <div><span class="doc-author">{{ author }}</span></div>
    <div class="center"><span class="doc-date">{{ date }}</span></div>
    <div><span class="doc-state">{{ state }}</span></div>
    <div><span class="doc-description">{{ description }}</span></div>
  </div>
</template>

<style lang="scss" scope>
@import "@/assets/style/main.scss";

.doc-element {
  @include doc-grid();

  justify-content: center;
  align-items: stretch;
  border-left: 3px solid $very-light-blue;

  .center {
    text-align: center;
  }

  div {
    border: 0px solid $very-light-blue;
    border-right-width: 3px;
    border-bottom-width: 3px;

    border-bottom: 3px solid $very-light-blue;
    border-right: 3px solid $very-light-blue;

    height: 20px;
    padding: 10px;

    display: grid;

    span {
      align-self: center;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
  }
}

.radio-doc {
  width: 22px;
  height: 22px;

  input:where([type="radio"]) {
    -webkit-appearance: none;
    appearance: none;
    width: 22px;
    height: 22px;
    margin: calc(0.75em - 11px) 0.25rem 0 0;
    vertical-align: top;
    border-radius: 4px;

    border-radius: 50%;
    background-color: $very-light-blue;
  }

  input[type="radio"]:checked {
    border: 7px solid $dark-blue;
    background: white;
    transition: all 200ms ease-in-out;

  }
}
</style>