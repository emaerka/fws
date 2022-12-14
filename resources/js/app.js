import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import Layout from './Layout'

createInertiaApp({
  resolve: name => {
    const page = require(`./Pages/${name}`).default
    page.layout = page.layout || Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    const VueApp = createApp({ render: () => h(App, props) })
     

      VueApp.config.globalProperties.$route = route;

    VueApp.use(plugin)
    .component('Link', Link)
    .mixin({
      methods: {
          route
      }
    })
    .mount(el)
  },
})

InertiaProgress.init({
    color: '#4B5563',
    showSpinner: true,
});