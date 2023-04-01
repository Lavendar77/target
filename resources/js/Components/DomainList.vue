<template>
  <div>
    <h6 class="text-h6">Choose a domain to manage:</h6>

    <v-slide-group
      show-arrows
    >
      <v-slide-group-item
        v-for="domain in domains"
        :key="domain.id"
      >
        <v-btn
          class="ma-2"
          rounded
          :color="$page.url == `/dashboard?d=${domain.id}` ? 'primary' : undefined"
          @click="visitLink(domain.id)"
        >
          {{ domain.name }}
        </v-btn>
      </v-slide-group-item>
    </v-slide-group>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
</script>

<script>
export default {
  props: {
    domains: {
      type: Array
    },
    domain: {
      type: String,
      required: false
    }
  },
  methods: {
    visitLink(id) {
      router.get(route('dashboard', { d: id }));
    }
  }
}
</script>
