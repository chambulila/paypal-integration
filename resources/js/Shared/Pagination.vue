<template>
  <nav class="py-4 px-4" aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
    <li v-for="(link, key) in links" :key="key" class="page-item"  :class="{'active' : link.active }">
      <Link class="page-link" :key="`link-${key}`"  :href="link.url" v-html="link.label" />
    </li>
  </ul>
</nav>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  components: {
    Link,
  },
  props: {
    links: Array,
  },
}
</script>
