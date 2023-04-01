<template>
  <v-card>
    <v-card-title>
      {{ domain ? 'Update' : 'Create' }} Domain
    </v-card-title>

    <v-form ref="domainForm" @submit.prevent="domain ? updateDomain() : createDomain()" fast-fail>
      <v-card-text>
        <v-text-field
          label="Name"
          variant="underlined"
          :rules="[rules.required]"
          v-model="form.name"
          :error-messages="form.errors.name"
        ></v-text-field>

        <v-text-field
          type="url"
          label="Domain"
          variant="underlined"
          :rules="[rules.required]"
          v-model="form.base_url"
          :error-messages="form.errors.base_url"
        ></v-text-field>
      </v-card-text>

      <v-card-actions>
        <v-btn type="button" color="secondary" @click="closeDomainFormDialog">
          Close
        </v-btn>

        <v-spacer></v-spacer>

        <v-btn
          type="submit"
          color="primary"
        >
          {{ domain ? 'Update' : 'Create' }} Domain
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
  props: {
    domain: {
      type: Object,
      required: false,
    }
  },
  data() {
    return {
      rules: {
        required: v => !!v || 'This field is required',
      },
      form: useForm({
        name: '',
        base_url: '',
      })
    }
  },
  methods: {
    closeDomainFormDialog() {
      this.$emit("closeDomainFormDialog");
    },
    async createDomain() {
      const { valid } = await this.$refs.domainForm.validate();

      if (!valid) {
        return;
      }

      this.form.post(route('domain.store'), {
        onSuccess: () => this.closeDomainFormDialog(),
      });
    },
    async updateDomain() {
      const { valid } = await this.$refs.domainForm.validate();

      if (!valid) {
        return;
      }

      this.form.put(route('domain.update', this.domain.id), {
        onSuccess: () => this.closeDomainFormDialog(),
      });
    }
  },
  mounted() {
    if (this.domain) {
      this.form.name = this.domain.name;
      this.form.base_url = this.domain.base_url;
    }
  }
}
</script>