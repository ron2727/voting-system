import { createApp, markRaw } from 'vue'
import { createPinia } from 'pinia'
import router from './router'

import './axios'
import './style.css'

import App from './App.vue'

const pinia = createPinia();

const app = createApp(App);

pinia.use(({ store }) => {
    store.router = markRaw(router)
});

app.use(pinia)
app.use(router)

app.mount('#app')