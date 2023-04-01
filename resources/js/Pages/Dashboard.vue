<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="d-flex justify-space-between align-self-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        <v-btn @click="openDomainForm = true">
          Create Domain
        </v-btn>
      </div>
    </template>

    <DomainList :domains="domains" :domainId="domain_id" :domainRuleEnum="rules" />

    <v-dialog
      v-model="openDomainForm"
      width="1024"
    >
      <DomainForm @closeDomainFormDialog="openDomainForm = false" />
    </v-dialog>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import DomainForm from '@/Components/DomainForm.vue';
import DomainList from '@/Components/DomainList.vue';

defineProps({
  domains: {
    type: Array,
  },
  domain_id: {
    type: String,
    required: false,
  },
  rules: {
    type: Array
  }
});

const openDomainForm = ref(false);
</script>
