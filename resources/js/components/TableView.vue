<template lang="pug">
    .table-responsive
        table.table.table-striped
            thead(v-if="header")
                tr
                    th(v-for="col in header")
                        router-link(:to="pushableToOrder(col)", v-html="columnHeader(col)")
            tbody(v-if="rows")
                tr(v-for="row in rows")
                    td(v-for="value in row")
                        | {{ value }}

</template>

<script>
  export default {
    name: "TableView",
    props: ['orderBy', 'orderDir', 'header', 'rows'],
    methods: {
      columnHeader(col) {
        let name = '';
        if (this.orderBy === col.key) {
          if (this.orderDir === 'asc') {
            // arrow up
            name += '&#x2B06;';
          } else {
            // arow down
            name += '&#x2B07;';
          }
        }
        name += col.title;
        return name;
      },

      pushableToOrder(col) {
        let order = {};
        if (col.key === this.orderBy) {
          // existing column swith direction
          order.orderBy = col.key;
          order.orderDir = this.orderDir === 'asc' ? 'desc' : 'asc';
        } else {
          // new order  - defaullt direction is asc
          order.orderBy = col.key;
          order.orderDir = 'asc';
        }

        return {
          query: {
            ...this.$route.query,
            ...order,
            page: 1,
          }
        };
      }
    }
  };
</script>
