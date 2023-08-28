import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { InertiaProgress } from "@inertiajs/progress";
import { Link } from '@inertiajs/vue3'
import Header from './Pages/Header.vue'

InertiaProgress.init();
createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component("Link", Link)
      .mount(el)
  },
  components: {
    Header
  }
})




