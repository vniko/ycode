<template>
    <nav v-if="lastPage > 1">
        <ul class="pagination">
            <li v-if="currentPage > 1" class="page-item hidden-lg-down">
                <router-link :to="pushableToPage(currentPage - 1)" class="page-link">
                    Prev. page
                </router-link>
            </li>

            <li class="page-item" :class="{'active': currentPage === 1}">
                <router-link :to="pushableToPage(1)" class="page-link">
                    1
                </router-link>
            </li>
            <li v-if="currentPage - range > 2" class="page-item">
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
            <li v-for="num in middlePageNumbers" class="page-item" :class="{'active': currentPage === num}">
                <router-link :to="pushableToPage(num)" class="page-link">
                    {{ num }}
                </router-link>
            </li>
            <li v-if="currentPage + range < lastPage - 1" class="page-item">
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
            <li class="page-item" :class="{'active': currentPage === lastPage}">
                <router-link :to="pushableToPage(lastPage)">
          <span class="page-link" v-if="lastPage > 1" tabindex="0" aria-label="Goto Last Page">
            {{ lastPage }}
          </span>
                </router-link>
            </li>
            <li v-if="currentPage < lastPage" class="page-item hidden-lg-down">
                <router-link :to="pushableToPage(currentPage + 1)" class="page-link">
                    Next page
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<script>

  /**
   * makes a sequence starting from zero to len
   * @param  integer len
   * @return array<integer>
   */
  function sequence(len) {
    return Array.apply(null, Array(len));
  }

  export default {
    props: {
      collection: {
        type: Object,
        required: true,
        validator(collection) {
          const data = collection.data;
          const pm = collection.meta.pagination;
          console.assert(typeof data === 'object', 'Collection must be object');
          console.assert(!isNaN(parseInt(data.length)), 'Collection must have collection.data with length as positive integer');
          console.assert(!isNaN(parseInt(pm.total)), 'Collection must have collection.total as positive integer');

          console.assert(!isNaN(parseInt(pm.per_page)), 'Collection must have collection.per_page as positive integer');
          console.assert(!isNaN(parseInt(pm.current_page)), 'Collection must have collection.current_page as positive integer');
          /* convert to laravel semantics */
          pm.limit = pm.per_page;
          pm.skip = pm.per_page * (pm.current_page - 1);


          console.assert(!isNaN(parseInt(pm.skip)), 'Collection must have collection.skip as positive integer');
          console.assert(!isNaN(parseInt(pm.limit)), 'Collection must have collection.limit as positive integer');

          return true;
        },
      },
      limit: {
        type: Number,
        default() {
          return 15;
        },
      },
      /* how many extra numbers to show */
      range: {
        type: Number,
        default() {
          return 3;
        },
      },
    },
    computed: {
      // limit() {
      //   return parseInt(this.collection.meta.pagination.limit);
      // },
      total() {
        return parseInt(this.collection.meta.pagination.total);
      },
      skip() {
        return parseInt(this.collection.meta.pagination.skip);
      },
      currentPage() {
        return parseInt(this.collection.meta.pagination.current_page);
      },
      lastPage() {
        return this.collection.meta.pagination.total_pages;
      },
      offset() {
        return this.skip;
      },
      middlePageNumbers() {
        return sequence(1 + 2 * this.range)
          .map((x, y) => this.currentPage + y - this.range)
          .filter(v => v > 1 && v < this.lastPage)
          ;
      },
    },
    methods: {
      gotoPage(num) {
        if (this.currentPage === num) return false;
        const nextPush = this.pushableToPage(num);
        this.$router.push(nextPush);
      },
      pushableToPage(num) {
        return {
          query: {
            ...this.$route.query,
            page: num,
          },
        };
      }
    },
  }
</script>

<style lang="css" scoped>
    a {
        cursor: pointer;
    }
</style>
