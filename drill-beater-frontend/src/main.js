
import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import {createPinia} from "pinia";
import {VueQueryPlugin} from '@tanstack/vue-query'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"


const app = createApp(App)
app.use(createPinia())
app.use(VueQueryPlugin)

app.use(router)

app.mount('#app')
