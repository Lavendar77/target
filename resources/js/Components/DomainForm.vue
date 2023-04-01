<template>
  <v-card>
    <v-card-title>
      Create a Domain
    </v-card-title>

    <v-form ref="domainForm" @submit.prevent="createDomain" fast-fail>
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
          Create Domain
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
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
    }
  }
}
</script>