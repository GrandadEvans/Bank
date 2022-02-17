<template>
    <div>
        <section>
            <div v-if="resultsAreReady">
                <section style="margin:1rem">
                    <h1 style="flex-grow: 1; text-align: center">
                        &ldquo;{{ this.name }}&rdquo; appears every <strong>{{ this.periodString }}</strong>
                    </h1>
                    <div class="btn-group" style="display: flex">
                        <button
                            class="btn btn-warning"
                            style="margin-right: 0.5rem"
                            @click="this.decline"
                            :disabled="buttonsDisabled"
                        >Decline
                        </button>
                        <button class="btn btn-secondary" style="margin-left: 0.5rem; margin-right: 0.5rem;"
                                @click="this.postpone"
                                :disabled="buttonsDisabled"
                        >Not Sure
                        </button>
                        <button
                            class="btn btn-primary"
                            style="margin-left: 0.5rem"
                            @click="this.addNewRegular"
                            :disabled="buttonsDisabled"
                        >Accept
                        </button>
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
            <div v-else-if="!noResults">
                <base-loader/>
            </div>

            <div v-else>
                <p style="font-size: 2rem">There are no <strong>new</strong> potential regulars left to decide upon.</p>
                <p>Option #1: <a :href="possible_regulars__scan" @click.prevent.stop="scanForNewRegulars">Perform a
                    scan</a> and see if any more are available.
                </p>
                <p>Option #2: Decide on the ones that you have previously chosen to postpone.</p>
            </div>
        </section>
        <bank-modal-add-regular v-on:success="accept"></bank-modal-add-regular>

    </div>
</template>

<script>
export default {
    name: "new-regular-scan-results-table",
    data: function () {
        return {
            periodName: '',
            periodMultiplier: 1,
            name: '',
            transactions: [],
            totalDistinct: 0,
            providerSelected: null,
            paymentMethodId: null,
            providerId: null,
            lastFiveEntries: null,
            lastTenEntries: null,
            lastSixMonths: null,
            lastOneYear: null,
            inputDate: '',
            inputAmount: 0,
            inputDescription: '',
            inputRemarks: '',
            inputEstimated: false,
            waitingForRegularsModal: false,
            buttonsDisabled: false,
        }
    },
    props: [
        'read_only',
        'possible_regulars__scan'
    ],
    computed: {
        resultsAreReady() {
            return (this.regularsLoaded === true && !this.noResults);
        },
        possibleNewRegularsLoaded: function () {
            return this.$store.state.possibleNewRegularsLoaded;
        },
        regularsLoaded: function () {
            return this.$store.state.regularsLoaded;
        },
        noResults: function () {
            return this.totalDistinct === 0;
        },
        periodString: function () {
            if (this.periodMultiplier > 1) {
                return ` ${this.periodMultiplier} ${this.periodName}s`;
            }
            return this.periodName;
        },
        newRegularDetected: function () {
            if (this.$store.state.newRegularDetails !== {} && this.waitingForRegularsModal) {
                this.accept();
            }
        }
    },
    methods: {
        async loadPage(returnedData) {
            if (returnedData.data === 'no results') {
              this.$store.commit('possibleNewRegularsLoaded', false);
              this.$store.commit('regularsLoaded', false);
            } else {
                this.transactions = returnedData.data.data.transactions;

                let stats = returnedData.data.stats;
                this.name = stats.name;
                this.periodName = returnedData.data.stats.period_name;
                this.periodMultiplier = returnedData.data.stats.period_multiplier;
                this.totalPages = stats.totalDistinct;
                this.id = stats.id;
                this.$store.commit('updateNewRegularDetails', {
                    payment_method_id: stats.paymentMethodId,
                    provider_id: stats.providerId,
                    date: stats.nextDate,
                    amount: this.transactions[0].amount,
                    transaction_id: this.transactions[0].id,
                    entry: this.transactions[0].entry,
                    remarks: this.transactions[0].remarks,
                    period_name: this.periodName,
                    period_multiplier: this.periodMultiplier
                }),
                    this.$store.commit('updateNewRegularDetailsLoaded', true);
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
            this.buttonsDisabled = true;
            window.addRegularModal.hide();
            this.buttonsDisabled = false;
            this.waitingForRegularsModal = false;
            let returnedData = await axios.post(`/possible-regulars/accept`);
            // console.log(returnedData)
            if (returnedData.status === 202) {
                Toast.fire('Marked as ACCEPTED :-)');
                if (returnedData.data === "no results") {
                    this.totalDistinct = 0;
                } else {
                    this.loadPage(returnedData)
                }
            } else {
                Toast.fire('ERROR!');
                // @todo Handle error
            }
        },
        async decline() {
            let returnedData = await axios.post(`/possible-regulars/decline`);
            // console.log(returnedData)
            if (returnedData.status === 202) {
                Toast.fire('Marked at DECLINED :-)');
                this.loadPage(returnedData)
            } else {
                Toast.fire('ERROR!');
                // @todo Handle error
            }
        },
        async postpone() {
            let returnedData = await axios.post(`/possible-regulars/postpone`);
            // console.log(returnedData)
            if (returnedData.status === 202) {
              Toast.fire('Marked at POSTPONED :-)');
                this.loadPage(returnedData)
            } else {
                Toast.fire('ERROR!');
                // @todo Handle error
            }
        },
        async getData(url = '/possible-regulars/first') {
            let data = await axios.get(url);
            this.loadPage(data);
        },
        addNewRegular: function () {
            this.waitingForRegularsModal = true;
            this.$store.commit('updateModalToShow', 'add-regular-modal')
            // this.$store.commit('updateModalTransactionId', this.transaction_id)
            // this.$store.commit('updateModalIndex', this.$props.index)
            window.addRegularModal.show();
        },
        async updateProviders() {
            // console.log('updating providers')
            this.providerContent = '';
            let url = `/providers/simple_list`;
            const returnedData = await axios.get(url);
            this.$store.commit('updateProvidersData', returnedData.data);
        },
        async scanForNewRegulars() {
            let returnedData = await axios.get('/possible-regulars/scan'),
                type = '',
                title = '',
                text = '';

            if (returnedData.status === 202) {
                type = 'success';
                title = 'Success';
                text = 'A new scan is underway, and you\'ll be informed of the results in a few minutes';
            } else {
                type = 'error';
                title = 'Error!';
                text = 'There was an unknown error whilst requesting your latest regular transaction scan.<br />Please contact me if this has ruined your life';
            }

            Swal.fire({
                'type': type,
                'title': title,
                'text': text,
            });
        },

    },
    mounted: function () {
      let data = this.getData();
      if (this.$store.state.providersData.length === 0) {
        this.updateProviders();
      }
    },
}
</script>

<style>
.regular_table {
    width: 98%;
    margin: 1rem auto;
}
</style>
