import { createStore } from 'vuex';
import apiModule from './modules/api.js';

const store = createStore({
  modules: {
    api: apiModule,
  }
});

export default store;