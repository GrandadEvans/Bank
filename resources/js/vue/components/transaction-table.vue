<template>
    <div v-if="transactionsLoaded === true">
        <keep-alive>
            <search/>
        </keep-alive>
        <keep-alive>
            <pagination-links v-on:change-page="onChangePage" v-on:change-limit="onChangeLimit"/>
        </keep-alive>
        <keep-alive>
            <table
                v-if="transactionsLoaded === true"
                :source="this.source"
                id="transactions-table"
                class="table table-striped table-hover table-bordered transactions-table">

                <caption>List of Transactions</caption>
                <transaction-table-header v-if="transactionsLoaded === true"/>
                <transaction-table-body v-if="transactionsLoaded === true"/>
                <transaction-table-footer v-if="transactionsLoaded === true"/>
            </table>
        </keep-alive>
        <keep-alive>
            <pagination-links v-on:change-page="onChangePage" v-on:change-limit="onChangeLimit"/>
        </keep-alive>
    </div>
</template>

<script>
    export default {
        name: "transaction-table",
        props: ['source'],
        computed: {
            transactionsLoaded: function () {
                return this.$store.state.transactionsLoaded;
            }
        },
        methods: {
            onChangePage: function (page) {
                let limit = this.$store.state.latestTransactionTableStats.limit;
                this.loadPage(page, limit);
            },
            onChangeLimit: function (limit) {
                this.loadPage(1, limit);
            },
            async loadPage(page = 1, limit = 25) {
                let url = `/transactions/all/${page}/${limit}`;
                this.$store.commit('transactionsLoaded', false);
                const returnedData = await axios.get(url);
                this.$store.commit('updateLatestTransactionTableData', returnedData.data.data);
                this.$store.commit('updateLatestTransactionTableStats', returnedData.data.stats);
                this.$store.commit('transactionsLoaded', true);
            },
        },
        mounted: function() {
            this.loadPage();
        },
    }
</script>

<style>
</style>
