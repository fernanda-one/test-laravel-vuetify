import { createApp } from 'vue'
import App from '@/App.vue'
import { registerPlugins } from '@core/utils/plugins'

// Styles
import '@core/scss/template/index.scss'
import '@layouts/styles/index.scss'
import api from './plugins/axios'

// Create vue app
const app = createApp(App)
app.config.globalProperties.$axios = api

// Register plugins
registerPlugins(app)

// Mount vue app
app.mount('#app')
