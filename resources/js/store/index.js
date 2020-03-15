import Vue from 'vue';
import Vuex from 'vuex';
import api from '@/api'

Vue.use(Vuex);

const state = {
  websites: {},
  validationErrors: null,
};

const getters = {
  websitesTableData() {
    if (state.websites && state.websites.data) {
      return state.websites.data.map((row) => {
        return [row.name, row.url];
      });
    }
    return [];
  }
};

const actions = {
  async fetchWebsites({commit}, params) {
    try {
      const resp = await api.get('website', {params});
      commit('setWebsites', resp.data)
    } catch (e) {
      console.error(e);
    }
  },

  async submitNewSite({commit}, data) {
    commit('setValidationErrors', null);
    try {
      return await api.post('website', {...data});
    } catch (e) {
      // validation error
      if (e.response.status === 422) {
        commit('setValidationErrors', e.response.data.errors);
      }
    }

  }
};

const mutations = {
  setWebsites(state, data) {
    state.websites = data;
  },
  setValidationErrors(state, data) {
    state.validationErrors = data;
  },
};

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters,
});
