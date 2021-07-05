<template>
    <nav class="pagination" aria-label="Page navigation example">
        <ul class="pagination justify-content-center">

            <li class="page-item" v-if="page > 1" v-on:click="$emit('change-page', 1)">
                <a class="page-link" href="#">First</a>
            </li>
            <li class="page-item" v-if="page > 1" v-on:click="$emit('change-page', (page-1))">
                <a class="page-link" href="#">Previous</a>
            </li>

            <li class="page-item" v-if="(page-3) > 0" v-on:click="$emit('change-page', (page-3))">
                <a class="page-link" href="#">{{ page - 3 }}</a>
            </li>
            <li class="page-item" v-if="(page-2) > 0" v-on:click="$emit('change-page', (page-2))">
                <a class="page-link" href="#">{{ page - 2 }}</a>
            </li>
            <li class="page-item" v-if="(page-1) > 0" v-on:click="$emit('change-page', (page-1))">
                <a class="page-link" href="#">{{ page - 1 }}</a>
            </li>

            <li class="page-item active" aria-current="page">
                <a class="page-link current_page" href="#">{{ page }}</a>
            </li>

            <li class="page-item" v-if="(page+1)<= possibleNumberPages()"  v-on:click="$emit('change-page', (page+1))">
                <a class="page-link" href="#">{{ page + 1 }}</a>
            </li>
            <li class="page-item" v-if="(page+2)<=possibleNumberPages()"  v-on:click="$emit('change-page', (page+2))">
                <a class="page-link" href="#">{{ page + 2 }}</a>
            </li>
            <li class="page-item" v-if="(page+3)<=possibleNumberPages()"  v-on:click="$emit('change-page', (page+3))">
                <a class="page-link" href="#">{{ page + 3 }}</a>
            </li>

            <li class="page-item" v-if="page < possibleNumberPages()" v-on:click="$emit('change-page', (page+1))">
                <a class="page-link" href="#">Next</a>
            </li>
            <li class="page-item" v-if="page < possibleNumberPages()" v-on:click="$emit('change-page', possibleNumberPages())">
                <a class="page-link" href="#">Last</a>
            </li>

        </ul>

        <ul class="pagination justify-content-start">

            <li :class="isCurrentLimit(10)" v-on:click="$emit('change-limit', 10)">
                <a class="page-link" href="#">10</a>
            </li>
            <li :class="isCurrentLimit(25)" v-on:click="$emit('change-limit', 25)">
                <a class="page-link" href="#">25</a>
            </li>
            <li :class="isCurrentLimit(50)" v-on:click="$emit('change-limit', 50)">
                <a class="page-link" href="#">50</a>
            </li>
            <li :class="isCurrentLimit(100)" v-on:click="$emit('change-limit', 100)">
                <a class="page-link" href="#">100</a>
            </li>
            <li :class="isCurrentLimit(200)" v-on:click="$emit('change-limit', 200)">
                <a class="page-link" href="#">200</a>
            </li>

        </ul>
    </nav>
</template>

<script>
export default {
    name: "pagination-links",
    computed: {
        page () {
            return this.latestTransactionTableStats.page;
        },
        latestTransactionTableStats: function () {
            return this.$store.state.latestTransactionTableStats;
        }
    },
    methods: {
        updateTransactions: function (page) {
            this.$emit('updateTransactions', [page])
        },
        possibleNumberPages: function () {
            return this.latestTransactionTableStats.totalRecords / this.latestTransactionTableStats.limit;
        },
        linkTitleGoToPage: function (page) {
            return `Go to page ${page}`;
        },
        isCurrentLimit: function (limit) {
            if (this.latestTransactionTableStats.limit === limit) {
                return "page-item active";
            } else {
                return "page-item";
            }
        }
    }
}

</script>

<style scoped>
nav {
    flex-flow: row;
    justify-content: space-between;
}
</style>
