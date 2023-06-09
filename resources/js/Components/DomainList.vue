<template>
  <div>
    <h6 class="text-h6" v-if="domains.length">Choose a domain to manage:</h6>
    <v-alert color="warning" icon="$warning" v-else>Create a domain to get started</v-alert>

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
          :color="isSelected(domain.id) ? 'primary' : undefined"
          @click="visitLink(domain.id)"
        >
          {{ domain.name }}
        </v-btn>
      </v-slide-group-item>
    </v-slide-group>

    <v-card class="mt-5 mx-auto" v-if="domain">
      <v-card-title>
        <div class="d-flex">
          <v-btn
            prepend-icon="mdi-pencil"
            variant="text"
            color="primary"
            @click="editDomain(domain)"
          >
            {{ domain.name }}
          </v-btn>
          <v-btn
            prepend-icon="mdi-delete"
            color="error"
            variant="plain"
            @click="deleteDomain"
          >
            Delete Domain
          </v-btn>
        </div>
      </v-card-title>

      <v-code class="py-3 pa-4" v-if="domain.rules.length">
        Add this script to the &lt;head&gt; of your domain
        <a :href="domain.base_url" target="_blank" class="text-info">
          {{ domain.base_url }}
        </a>
        :<br />
        <b v-html="script"></b>
      </v-code>

      <v-form ref="domainRuleForm" @submit.prevent="submitDomainRule">
        <v-btn
          prepend-icon="mdi-plus"
          color="success"
          variant="text"
          @click="addRuleGroup()"
          title="Add Alert Group"
        >
          Add New Alert Message
        </v-btn>

        <v-alert
          color="error"
          icon="$error"
          title="Invalid data"
          :text="errors.domain_rules"
          v-if="Object.keys(errors).length"
        ></v-alert>

        <v-card-text v-for="(domainRule, index) in domainRules" :key="index">
          <p class="text-subtitle-1 font-weight-bold text-primary">
            {{ index + 1 }}. Alert
            <span v-if="domainRule.alert_text">to Show "{{ domainRule.alert_text }}"</span>

            <v-btn
              icon="mdi-delete"
              color="error"
              variant="text"
              @click="deleteRuleGroup(index)"
              title="Delete Alert Message"
              v-if="domainRules.length > 1"
            ></v-btn>
          </p>

          <v-text-field
            v-model="domainRule.alert_text"
            :rules="[rules.required]"
            label="Alert Text"
            hint="What text do you want to popup?"
            persistent-hint
            counter
          ></v-text-field>

          <div class="px-3 mt-4">
            <v-table density="compact" hover>
              <thead>
                <tr>
                  <th width="25%">Display Setting</th>
                  <th width="25%">Rule</th>
                  <th width="40%">Page Link</th>
                  <th>
                    <v-btn
                      prepend-icon="mdi-plus"
                      color="success"
                      variant="text"
                      @click="addRule(index)"
                      :title="`Add New Rule for ${domainRule.alert_text}`"
                    >
                      Add New Rule
                    </v-btn>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(rule, ruleIndex) in domainRule.rules">
                  <td>
                    <v-select
                      :items="[
                        { title: 'Show', value: 1 },
                        { title: 'Do Not Show', value: 0 },
                      ]"
                      item-title="title"
                      item-value="value"
                      variant="underlined"
                      v-model="rule.show_alert"
                    ></v-select>
                  </td>
                  <td>
                    <v-select
                      :items="generalRules"
                      item-title="title"
                      item-value="value"
                      variant="underlined"
                      v-model="rule.rule"
                      :rules="[rules.required]"
                    ></v-select>
                  </td>
                  <td>
                    <v-text-field
                      v-model="rule.page"
                      label="Page"
                      hint="Page on website. Leave blank for the homepage"
                      placeholder="about"
                      :prefix="domain.base_url + '/'"
                      variant="underlined"
                      persistent-hint
                    ></v-text-field>
                  </td>
                  <td>
                    <v-btn
                      icon="mdi-delete"
                      variant="text"
                      color="error"
                      v-if="domainRule.rules.length > 1"
                      @click="deleteRule(index, ruleIndex)"
                    ></v-btn>
                  </td>
                </tr>
              </tbody>
            </v-table>
          </div>
        </v-card-text>

        <v-card-actions>
          <v-btn
            type="submit"
            color="primary"
            variant="tonal"
            block
          >
            Submit Domain Rules
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </div>
</template>

<script>
import { router } from '@inertiajs/vue3'
import { DomainRuleGroup, DomainRule } from '@/Models/DomainRuleGroup'

export default {
  props: {
    domains: {
      type: Array,
    },
    domainId: {
      type: String,
      required: false,
    },
    domainRuleEnum: {
      type: Array,
      required: true,
    },
    errors: {
      type: Object
    }
  },
  data() {
    return {
      rules: {
        required: v => !!v || 'This field is required',
      },
      domainRules: [new DomainRuleGroup()],
    }
  },
  computed: {
    domain() {
      if (!this.domainId) {
        return;
      }

      let domain = this.domains.filter((domain) => domain.id == this.domainId)[0];

      if (domain) {
        this.setDomainRules(domain);
      }

      return domain;
    },
    generalRules() {
      return this.domainRuleEnum.map((value) => {
        return {
          title: value.replace('_', ' '),
          value: value
        }
      });
    },
    script() {
      let host = window.location.protocol + "//" + window.location.host;
      return `&lt;script src="${host}/alert-worker.js?ref=${this.domain.reference}"&gt;` + '&lt;/script&gt;';
    }
  },
  methods: {
    visitLink(id) {
      router.get(route('dashboard', { d: id }));
    },
    isSelected(id) {
      return this.domainId == id;
    },
    setDomainRules(domain) {
      this.resetDomainRules();

      let rules = domain.rules.reduce(function(rule, value) {
        (rule[value['alert_text']] = rule[value['alert_text']] || []).push(value);

        return rule;
      }, {});

      let domainRules = [];
      Object.keys(rules).forEach((alertText) => {
        domainRules.push({
          alert_text: alertText,
          rules: rules[alertText].map((rule) => {
            return {
              show_alert: rule.show_alert ? 1 : 0,
              rule: rule.rule,
              page: rule.page,
            };
          })
        });
      });

      if (!domainRules.length) {
        return;
      }

      this.domainRules = domainRules;
    },
    addRuleGroup() {
      this.domainRules.push(new DomainRuleGroup());
    },
    deleteRuleGroup(index) {
      if (this.domainRules.length == 1) {
        return;
      }

      this.domainRules.splice(index, 1);
    },
    addRule(index) {
      if (!this.domainRules[index]) {
        return;
      }

      this.domainRules[index].rules.push(new DomainRule());
    },
    deleteRule(groupIndex, index) {
      if (!this.domainRules[groupIndex]) {
        return;
      }

      if (this.domainRules[groupIndex].rules.length == 1) {
        return;
      }

      this.domainRules[groupIndex].rules.splice(index, 1);
    },
    async submitDomainRule() {
      let { valid } = await this.$refs.domainRuleForm.validate();

      if (!valid) {
        return;
      }

      router.post(
        route('domain.rule.store', {
          domain: this.domain.id
        }),
        {
          domain_rules: this.domainRules,
          onSuccess: () => this.resetDomainRules()
        },
      );
    },
    resetDomainRules() {
      this.domainRules = [new DomainRuleGroup()];
    },
    deleteDomain() {
      if (confirm('Are you sure you want to delete this domain?')) {
        router.delete(route('domain.destroy', { domain: this.domain.id }))
      }
    },
    editDomain(domain) {
      this.$emit("openDomainFormDialog", domain);
    }
  }
}
</script>
