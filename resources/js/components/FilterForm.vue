<template lang="pug">
  div
    .row
      .col-8
        .form-group
          input.form-control(placeholder="Input search string", v-model="filterValue")
      .col-2
        button.btn.btn-primary(@click="applyFilter()") Apply filter
      .col-2
        button.btn.btn-default(@click="resetFilter()") Reset filter


</template>

<script>
  export default {
    name: 'FilterForm',
    props: ['filter'],
    data() {
      return {
        filterValue: null,
      }
    },
    methods: {
      applyFilter() {
        if (this.filterValue) {
          try {
            this.$router.push({
              query: {
                ...this.$route.query,
                filter: this.filterValue,
                page: 1,
              }
            });
          } catch (e) {

          }
        }
      },
      resetFilter() {
        this.filterValue = null;
        this.$router.push({
          query: {
            ...this.$route.query,
            filter: '',
            page: 1,
          }
        });
      },
    },
    mounted() {
      if (this.filter) {
        this.filterValue = this.filter;
      }
    }
  }
</script>