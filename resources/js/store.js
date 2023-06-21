import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('token') || null, // Initialize token from localStorage or as null
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
            localStorage.setItem('token', token); // Store the token in localStorage
        },
        clearToken(state) {
            state.token = null;
            localStorage.removeItem('token'); // Remove the token from localStorage
        },
    },
    actions: {
        // You can define additional actions here if needed
    },
    getters: {
        isAuthenticated: (state) => {
            return state.token;
        },
    },
});

export default store;
