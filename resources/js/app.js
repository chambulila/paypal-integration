import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { InertiaProgress } from "@inertiajs/progress";
import { Link } from '@inertiajs/vue3'
import Header from './Pages/Header.vue'
import Icon from './Shared/Icon.vue'
import PrimaryButton from './Shared/Buttons/PrimaryButton.vue'
import SecondaryButton from './Shared/Buttons/SecondaryButton.vue'
import DeleteButton from './Shared/Buttons/DeleteButton.vue'
import ButtonWithIcon from './Shared/Buttons/ButtonWithIcon.vue'
import PrimaryLink from './Shared/Links/PrimaryLink.vue'
import SecondaryLink from './Shared/Links/SecondaryLink.vue'
import DeleteLink from './Shared/Links/DeleteLink.vue'
import LinkWithIcon from './Shared/Links/LinkWithIcon.vue'
import FlashMessages from './Shared/FlashMessages.vue'

InertiaProgress.init();
createInertiaApp({
  progress: {
    color: '#A0261E',
    showSpinner: true,
    delay: 250,
    includeCSS: true,
  },
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component("Link", Link)
      .component("PrimaryButton", PrimaryButton)
      .component("SecondaryButton", SecondaryButton)
      .component("DeleteButton", DeleteButton)
      .component("ButtonWithIcon", ButtonWithIcon)
      .component("FlashMessages", FlashMessages)
      
      .component("PrimaryLink", PrimaryLink)
      .component("SecondaryLink", SecondaryLink)
      .component("DeleteLink", DeleteLink)
      .component("LinkWithIcon", LinkWithIcon)
      .component("icon", Icon)
      .component("Link", Link)
      .mount(el)
  },
  components: {
    Header
  }
})




