import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})



// import { createApp, h } from 'vue'
// import { createInertiaApp } from '@inertiajs/vue3'





// createInertiaApp({
//   progress: {
//     color: '#A0261E',
//     showSpinner: true,
//     delay: 250,
//     includeCSS: true,
//   },
//   resolve: name => require(`./Pages/${name}`),
//   setup({ el, App, props, plugin }) {
//     createApp({ render: () => h(App, props) })
//       .use(plugin)

    //   .component("HighchartsVue", HighchartsVue)
    //   .component('v-select', vSelect)
//       .mount(el)

//   },

// });
