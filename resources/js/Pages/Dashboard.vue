<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="d-flex justify-space-between align-self-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        <v-btn @click="openNewDomainForm">
          Create Domain
        </v-btn>
      </div>
    </template>

    <v-alert
      color="success"
      icon="$success"
      :title="$page.props.flash.message"
      v-if="$page.props.flash.message"
    ></v-alert>

    <DomainList
      :domains="domains"
      :domainId="domain_id"
      :domainRuleEnum="rules"
      :errors="errors"
      @openDomainFormDialog="openDomainFormDialog"
    />

    <v-dialog
      v-model="openDomainForm"
      width="1024"
    >
      <DomainForm @closeDomainFormDialog="openDomainForm = false" :domain="domain" />
    </v-dialog>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DomainForm from '@/Components/DomainForm.vue';
import DomainList from '@/Components/DomainList.vue';
</script>

<script>
export default {
  props: {
    domains: {
      type: Array,
    },
    domain_id: {
      type: String,
      required: false,
    },
    rules: {
      type: Array
    },
    errors: Object
  },
  data() {
    return {
      openDomainForm: false,
      domain: null,
    }
  },
  methods: {
    openNewDomainForm() {
      this.domain = null;
      this.openDomainForm = true;
    },
    openDomainFormDialog(domain) {
      this.domain = domain;
      this.openDomainForm = true;
    }
  }
}
</script>
