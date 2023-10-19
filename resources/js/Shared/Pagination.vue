<template>
  <nav class="py-4 px-4" aria-label="Page navigation example">
    <ul class="pagination pagination-dark flex">
    <li v-for="(link, key) in links" :key="key" class="page-item text-blue-700 gap-4"  :class="{'active' : link.active }">
      <Link class="page-link text-blue-700 gap-4" :key="`link-${key}`"  :href="link.url" v-html="link.label" />
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
