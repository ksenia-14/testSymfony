const apiModule = {
  namespaced: true, // Это приведет к тому, что все они замещаются в этом модуле
  state: {
    // api: '/fakeapi',
    api: '/api',
  },
  getters: {
    // apiDocsList: state => state.api + '/documents.json',
    // apiDocsSearch: state => state.api + '/documents_search.json',
    // apiDocsFilter: state => state.api + '/documents_search.json',
    // apiAuth: state => state.api + '/auth.json',
    // apiRegister: state => state.api + '/register.json',
    // apiDocNew: state => state.api + '/put.json',
    // apiDocDelete: state => (id) => {
    //   return state.api + '/delete.json'
    // },
    // apiDocEdit: state => (id) => {
    //   return state.api + '/put.json'
    // },
    // apiDocGet: state => (id) => {
    //   return state.api + '/one_file.json'
    // },

    apiDocsList: state => state.api + '/documents/',
    apiDocsSearch: state => state.api + '/documents/',
    apiDocsFilter: state => state.api + '/documents/filter/',
    apiAuth: state => state.api + '/auth/',
    apiRegister: state => state.api + '/register/',
    apiDocNew: state => state.api + '/document/',
    apiDocDelete: state => (id) => {
      return state.api + '/document/' + id + '/';
    },
    apiDocEdit: state => (id) => {
      return state.api + '/document/' + id + '/';
    },
    apiDocGet: state => (id) => {
      return state.api + '/document/' + id + '/';
    },
  },
};

export default apiModule;