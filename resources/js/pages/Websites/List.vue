<template lang="pug">
  .container.p-5
    .row
      .col-2
        h1 Websites
      .col-8
          filter-form(v-if="websites.data", :filter="filterString")
      .col-2
        .float-right
          router-link.btn.btn-success(tag="button", to="/websites/create")  + Add site

    .row
      table-view(:header="tableHeader", :rows="websitesTableData", :orderBy="orderBy", :orderDir="orderDir")

      pagination(:collection="websites", v-if="websites.data && websites.data.length")

</template>

<script>
  import TableView from "@/components/TableView";
  import Pagination from "@/components/Pagination";
  import FilterForm from "@/components/FilterForm";
  import { mapGetters, mapState } from "vuex";

  export default {
    name: "WebsitesList",
    components: { TableView, Pagination, FilterForm },
    data() {
      return {
        tableHeader: [

          { key: 'name', title: 'Website Name'},
          { key: 'url', title: 'Website URL'}
        ],

      };
    },
    computed: {
      ...mapGetters(["websitesTableData"]),
      ...mapState({
        websites: state => state.websites,
        }),

      filterString() {
        return this.$route.query.filter ||  '';
      },

      orderBy() {
        return this.$route.query.orderBy ||  'name';
      },

      orderDir() {
        return this.$route.query.orderDir ||  'asc';
      },
    },

    methods: {
      async fetchWebsites() {
        const page = this.$route.query.page || 1;
        this.$store.dispatch("fetchWebsites", {
            page,
            filter: this.filterString,
            orderBy: this.orderBy,
            orderDir: this.orderDir
        });
      }
    },

    created() {
      this.fetchWebsites();
    },

    watch: {
      $route(newRoute, oldRoute) {
        if (newRoute.path === oldRoute.path) {
          if (newRoute.fullPath !== oldRoute.fullPath) {
            this.fetchWebsites();
          }
        }
      },
    },
  };
</script>
