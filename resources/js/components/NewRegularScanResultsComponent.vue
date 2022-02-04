<template>
    <div>
        <section>
            <header style="display: flex">
                <button
                    class="btn btn-primary"
                    @click="previousPage"
                    v-if="this.linkedPageNumberIsValid(this.page - 1)"
                >Previous
                </button>

                <p style="flex-grow: 1; text-align: center; font-size: 1.5rem">
                    <span v-if="regularsLoaded === true">({{ this.page }} of {{ this.totalPages }})</span>
                    <span v-else><i class="fa fa-loading"/></span>
                </p>

                <button
                    class="btn btn-primary"
                    @click="nextPage"
                    v-if="this.linkedPageNumberIsValid(this.page + 1)"
                >Next
                </button>
            </header>

            <section style="margin:1rem" v-if="regularsLoaded === true">
                <h1 style="flex-grow: 1; text-align: center">
                    &ldquo;{{ this.name }}&rdquo; appears every <strong>{{ this.period }}</strong>
                </h1>
                <div class="btn-group" style="display: flex">
                    <button class="btn btn-warning" style="margin-right: 0.5rem">Decline</button>
                    <button class="btn btn-secondary" style="margin-left: 0.5rem; margin-right: 0.5rem;">Not Sure
                    </button>
                    <button class="btn btn-primary" style="margin-left: 0.5rem">Accept</button>
                </div>
            </section>

            <section style="margin-top: 0.5rem;" v-if="regularsLoaded === true">
                <table
                    id="regulars-table"
                    class="table table-striped table-hover table-bordered regulars-table">
                    <caption>Latest transactions</caption>

                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Current Provider</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions">
                            <th scope="row" class="column-date">
                                <td-date :date="transaction.date"/>
                            </th>
                            <td>
                                <td-amount :amount="transaction.amount"/>
                            </td>
                            <td>
                                <td-provider
                                    v-if="transaction.provider.name === 'N/A'"
                                    :transaction_id="transaction.id"
                                    :read_only="true"
                                ></td-provider>

                                <td-provider
                                    v-else
                                    :transaction_id="transaction.id"
                                >{{ transaction.provider.name }}
                                </td-provider>
                            </td>
                            <td>
                                <td-payment-method :method="transaction.payment_method"/>
                            </td>
                            <td>
                                <tags-list
                                    index=1
                                    mode="view"
                                    :tags="transaction.tags"
                                    :transaction_id="transaction.id"
                                    :read_only="true"
                                />
                            </td>
                            <td class="limit-cell-width text-truncate">{{ transaction.remarks }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section style="margin-top: 0.5rem;" v-if="regularsLoaded === true">
                <table
                    v-if="regularsLoaded === true"
                    id="regulars-table"
                    class="table table-striped table-hover table-bordered regulars-table">

                    <caption>Statistics</caption>

                    <thead>
                        <tr>
                            <th scope="col">Period</th>
                            <th scope="col">Total</th>
                            <th scope="col">Average</th>
                            <th scope="col"># of Entries</th>
                            <!--                        <th scope="col">% of Expenditure</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Last 5 Enrties</th>
                            <td>
                                <td-amount :amount="lastFiveEntries.total"/>
                            </td>
                            <td>
                                <td-amount :amount="lastFiveEntries.avg"/>
                            </td>
                            <td style="text-align: center">{{ this.lastFiveEntries.count }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Last 10 Enrties</th>
                            <td>
                                <td-amount :amount="lastTenEntries.total"/>
                            </td>
                            <td>
                                <td-amount :amount="lastTenEntries.avg"/>
                            </td>
                            <td style="text-align: center">{{ this.lastTenEntries.count }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Last 6 Months</th>
                            <td>
                                <td-amount :amount="lastSixMonths.total"/>
                            </td>
                            <td>
                                <td-amount :amount="lastSixMonths.avg"/>
                            </td>
                            <td style="text-align: center">{{ this.lastSixMonths.count }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Last Year</th>
                            <td>
                                <td-amount :amount="lastOneYear.total"/>
                            </td>
                            <td>
                                <td-amount :amount="lastOneYear.avg"/>
                            </td>
                            <td style="text-align: center">{{ this.lastOneYear.count }}</td>
                        </tr>
                        <tr>
                            <th scope="row">All Available Records</th>
                            <td>
                                <td-amount :amount="allTime.total"/>
                            </td>
                            <td>
                                <td-amount :amount="allTime.avg"/>
                            </td>
                            <td style="text-align: center">{{ this.allTime.count }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </section>
        <!--            <table-->
        <!--                class="table table-striped table-hover table-bordered regulars-table">-->


        <!--                <caption>List of Regulars Transactions</caption>-->
        <!--                <regular-table-header v-if="regularsLoaded === true"/>-->
        <!--                <regular-table-body v-if="regularsLoaded === true"/>-->
        <!--                <regular-table-footer v-if="regularsLoaded === true"/>-->
        <!--            </table>-->
        <!--        </keep-alive>-->
        <!--        <keep-alive>-->
        <!--            <pagination-links v-on:change-page="onChangePage" v-on:change-limit="onChangeLimit"></pagination-links>-->
        <!--        </keep-alive>-->
    </div>
</template>

<script>
export default {
    name: "new-regular-scan-results-table",
    data: function () {
        return {
            page: 1,
            period: '',
            name: '',
            lastFiveEntries: {},
            transactions: [],
            totalDistinct: 0,
        }
    },
    props: [
        'source',
        // 'page',
        'read_only'
    ],
    computed: {
        possibleNewRegularsLoaded: function () {
            return this.$store.state.possibleNewRegularsLoaded;
        },
        regularsLoaded: function () {
            return this.$store.state.regularsLoaded;
        },
    },
    methods: {
        onChangePage: function (page) {
            // let limit = this.$store.state.latestRegularTableStats.limit;
            // this.loadPage(page, limit);
        },
        onChangeLimit: function (limit) {
            this.loadPage(1, limit);
        },
        nextPage: function () {
            this.loadPage(this.page + 1);
        },
        previousPage: function () {
            this.loadPage(this.page - 1);
        },
        linkedPageNumberIsValid: function (page) {
            return (page < 1 || page > this.totalPages) ? false : true;
        },
        async loadPage(page = 1, limit = 25) {
            this.page = parseInt(page);

            let url = `/regulars/possible-new/${this.page}`;
            const returnedData = await axios.get(url);
            this.transactions = returnedData.data.data.transactions;

            let stats = returnedData.data.stats;
            this.name = stats.name;
            this.period = returnedData.data.stats.period;
            this.totalPages = stats.totalDistinct;

            this.$store.commit('updateLatestRegularTableData', this.transactions);
            this.$store.commit('possibleNewRegularsLoaded', false);
            this.$store.commit('regularsLoaded', false);
            this.$store.commit('updateLatestRegularTableStats', returnedData.data.stats);
            this.$store.commit('possibleNewRegularsLoaded', true);
            this.$store.commit('regularsLoaded', true);


            this.lastFiveEntries = {
                'total': stats.lastFiveEntries[0],
                'count': stats.lastFiveEntries[1],
                'avg': stats.lastFiveEntries[2]
            }
            this.lastTenEntries = {
                'total': stats.lastTenEntries[0],
                'count': stats.lastTenEntries[1],
                'avg': stats.lastTenEntries[2]
            }
            this.lastSixMonths = {
                'total': stats.lastSixMonths[0],
                'count': stats.lastSixMonths[1],
                'avg': stats.lastSixMonths[2]
            }
            this.lastOneYear = {
                'total': stats.lastOneYear[0],
                'count': stats.lastOneYear[1],
                'avg': stats.lastOneYear[2]
            }
            this.allTime = {
                'total': stats.allTime[0],
                'count': stats.allTime[1],
                'avg': stats.allTime[2]
            }
        },
    },
    mounted: function () {
        this.loadPage();
    },
}
</script>

<style>
.regular_table {
    width: 98%;
    margin: 1rem auto;
}
</style>
