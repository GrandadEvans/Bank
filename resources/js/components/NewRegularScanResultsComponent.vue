<template>
    <div>
        <section>
            <div v-if="regularsLoaded === true">
                <section style="margin:1rem">
                    <h1 style="flex-grow: 1; text-align: center">
                        &ldquo;{{ this.name }}&rdquo; appears every <strong>{{ this.period }}</strong>
                    </h1>
                    <div class="btn-group" style="display: flex">
                        <button class="btn btn-warning" style="margin-right: 0.5rem">Decline
                        </button>
                        <button class="btn btn-secondary" style="margin-left: 0.5rem; margin-right: 0.5rem;"
                        >Not Sure
                        </button>
                        <button class="btn btn-primary" style="margin-left: 0.5rem" @click="this.accept">Accept</button>
                    </div>
                </section>

                <section style="margin-top: 0.5rem;">
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

                <section style="margin-top: 0.5rem;">
                    <table
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
            </div>
            <div v-else>
                <h1>No Results</h1>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "new-regular-scan-results-table",
    data: function () {
        return {
            period: '',
            name: '',
            transactions: [],
            totalDistinct: 0,
        }
    },
    props: [
        'read_only'
    ],
    computed: {
        possibleNewRegularsLoaded: function () {
            return this.$store.state.possibleNewRegularsLoaded;
        },
        regularsLoaded: function () {
            return this.$store.state.regularsLoaded;
        },
        noResults: function () {
            return this.totalDistinct === 0;
        }
    },
    methods: {
        async loadPage(returnedData) {
            if (returnedData.data === 'no results') {
                this.$store.commit('possibleNewRegularsLoaded', true);
                this.$store.commit('regularsLoaded', true);
            } else {
                this.transactions = returnedData.data.data.transactions;

                let stats = returnedData.data.stats;
                this.name = stats.name;
                this.period = returnedData.data.stats.period;
                this.totalPages = stats.totalDistinct;
                this.id = stats.id;

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
            }
        },
        async accept() {
            let returnedData = await axios.get(`/possible-regulars/accept`);
            console.log(returnedData)
            if (returnedData.status === 202) {
                Toast.fire('Accepted :-)');
                this.loadPage(returnedData)
            } else {
                Toast.fire('ERROR!');
                // @todo Handle error
            }
        },
        async getData(url = '/possible-regulars/first') {
            let data = await axios.get(url);
            this.loadPage(data);
        }
    },
    mounted: function () {
        let data = this.getData();
    },
}
</script>

<style>
.regular_table {
    width: 98%;
    margin: 1rem auto;
}
</style>
