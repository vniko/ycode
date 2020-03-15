<template lang="pug">
    .container.p-5
        h1 Add New Website
        form.form
            .form-group
                label(for="name") Website Name
                input.form-control(type="text", id="name", v-model='formData.name', :class="{'is-invalid': validationErrors && validationErrors.name}")
                small.text-danger(v-if="validationErrors && validationErrors.name")
                    | {{ validationErrors.name.join(' ') }}
            .form-group
                label(for="url") Website Url
                input.form-control(type="text", id="url", v-model='formData.url', :class="{'is-invalid': validationErrors && validationErrors.url}")
                small.text-danger(v-if="validationErrors && validationErrors.url")
                  | {{ validationErrors.url.join('  ') }}

            button.btn.btn-primary(@click.prevent="submitForm") Add


</template>

<script>
  import { mapState } from "vuex";
  export default {
    name: 'WebsitesCreate',
    data() {
      return {
        formData: {
          name: '',
          url: '',
        }
      }
    },

    computed: {
      ...mapState({
        validationErrors: state => state.validationErrors,
      }),
    },

    methods: {
      async submitForm() {
        const resp = await this.$store.dispatch('submitNewSite', this.formData);
        if (resp) {
          alert('Website was created');
          this.$router.push('/websites');
        }
      }
    }
  }
</script>