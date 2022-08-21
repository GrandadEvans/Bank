<template>
    <div>
        <div v-if="transactionsLoaded === true">
                <search v-on:search="search"/>
                <pagination-links v-on:change-page="onChangePage" v-on:change-limit="onChangeLimit"/>
                <bank-navbar-time-limiter v-on:limit-period="limitPeriod" />
                <table
                    id="transactions-table"
                    class="table table-striped table-hover table-bordered transactions-table">

                    <caption>List of Transactions</caption>
                    <transaction-table-header v-if="transactionsLoaded === true"/>
                    <transaction-table-body v-if="transactionsLoaded === true"/>
                    <transaction-table-footer v-if="transactionsLoaded === true"/>
                </table>
                <pagination-links v-on:change-page="onChangePage" v-on:change-limit="onChangeLimit"/>

                <div id="stats">
                    <p>
                        Averages for the show transactions:<br />
                    Total number of entries: {{ numberOfEntriesShown }}<br />
                    Total amount of all show entries: {{ totalAmountShown }}<br />
                    Average entry amount: {{ averageAmountShown }}
                    </p>
                </div>
        </div>

        <div v-else>
            Transaction not yet loaded
        </div>
    </div>
</template>

<script>
import {currency} from '../../includes/helpers'

    export default {
        name: "transaction-table",
        props: ['source'],
        computed: {
            transactionsLoaded: function () {
                return this.$store.state.transactionsLoaded;
            }
        },
        data: function () {
            return {
                page: 1,
                limit: 25,
                period: 'unset',
                searchTerm: '',
                numberOfEntriesShown: 0,
                totalAmountShown: 0,
                averageAmountShown: 0
            }
        },
        methods: {
            onChangePage: function (page) {
                this.page = page;
                let limit = this.$store.state.latestTransactionTableStats.limit;
                this.limit = limit;
                this.loadPage();
            },
            limitPeriod: function (period) {
                this.period = period;
                this.loadPage();
            },
            onChangeLimit: function (limit) {
                this.limit = limit;
                this.loadPage();
            },
            async loadPage() {
                let page = this.page;
                let limit = this.limit;
                let period = this.period;
                let search = this.searchTerm;
                let url = `/transactions/all/${page}/${limit}/${period}/${search}`;
                // this.$store.commit('transactionsLoaded', false);
                const returnedData = await axios.get(url);
                let stats = returnedData.data.stats;
                this.numberOfEntriesShown = stats.numberOfEntriesShown;
                this.totalAmountShown = currency(stats.totalAmountShown);
                this.averageAmountShown = currency(stats.averageAmountShown);
                this.$store.commit('updateLatestTransactionTableData', returnedData.data.data);
                this.$store.commit('updateLatestTransactionTableStats', statsphp);
                this.$store.commit('transactionsLoaded', true);
            },
            search: function (term) {
                this.searchTerm = term;
                this.loadPage();
            }
        },
        mounted: function() {
            this.loadPage();
            window.scrollTo(0, 0);
        },
    }
</script>
