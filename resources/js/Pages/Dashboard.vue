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

    <div class="py-12">

    </div>

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

const openDomainForm = ref(false);
</script>
