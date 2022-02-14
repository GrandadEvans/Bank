<template>
    <div>
        <section>
            <header style="display: flex">
                <button class="btn btn-primary">Previous</button>
                <p style="flex-grow: 1; text-align: center; font-size: 1.5rem">(6 of 24)</p>
                <button class="btn btn-primary">Next</button>
            </header>

            <section style="margin:1rem">
                <h1 style="flex-grow: 1; text-align: center">&ldquo;{{ this.name }}&rdquo; appears every
                    <strong>{{ this.period }}</strong></h1>
                <div class="btn-group" style="display: flex">
                    <button class="btn btn-warning" style="margin-right: 0.5rem">Decline</button>
                    <button class="btn btn-secondary" style="margin-left: 0.5rem; margin-right: 0.5rem;">Not Sure
                    </button>
                    <button class="btn btn-primary" style="margin-left: 0.5rem">Accept</button>
                </div>
            </section>

            <section style="margin-top: 0.5rem;">
                <table
                    v-if="regularsLoaded === true"
                    id="regulars-table"
                    class="table table-striped table-hover table-bordered regulars-table">

                    <caption>Latest transactions</caption>

                    <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Current Provider</th>
                        <th scope="col">Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row" class="column-date">21 Mar 2021</th>
                        <td class="currency-amount currency-positive">&pound; 37.89</td>
                        <td style="text-align: center">Aldi</td>
                        <td>Bought a mower as well as food</td>
                    </tr>
                    <tr>
                        <th scope="row" class="column-date">17 Mar 2021</th>
                        <td class="currency-amount currency-positive">&pound; 89.75</td>
                        <td style="text-align: center">Aldi</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <th scope="row" class="column-date">10 Mar 2021</th>
                        <td class="currency-amount currency-positive">&pound; 87.25</td>
                        <td style="text-align: center">Aldi</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <th scope="row" class="column-date">03 Mar 2021</th>
                        <td class="currency-amount currency-positive">&pound; 45.57</td>
                        <td style="text-align: center">Aldi</td>
                        <td>Lost revipet but bought the kettle</td>
                    </tr>
                    <tr>
                        <th scope="row" class="column-date">26 Feb 2021</th>
                        <td class="currency-amount currency-positive">&pound; 45.86</td>
                        <td style="text-align: center">Aldi</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <th scope="row" class="column-date">19 Feb 2021</th>
                        <td class="currency-amount currency-positive">&pound; 99.99</td>
                        <td style="text-align: center">Aldi</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Last 5 entries</th>
                        <td class="currency-amount currency-positive">&pound;258.54</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    </tfoot>
                </table>
            </section>

            <section style="margin-top: 0.5rem;">
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
                        <th scope="col">% of Expenditure</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Last 5 Enrties</th>
                        <td class="currency-amount currency-positive">&pound; 258.54</td>
                        <td class="currency-amount currency-positive">&pound; 66.54</td>
                        <td style="text-align: center">5</td>
                        <td style="text-align: center">5.56 &percnt;</td>
                    </tr>
                    <tr>
                        <th scope="row">Last 10 Enrties</th>
                        <td class="currency-amount currency-positive">&pound; 641.58</td>
                        <td class="currency-amount currency-positive">&pound; 61.35</td>
                        <td style="text-align: center">10</td>
                        <td style="text-align: center">6.06 &percnt;</td>
                    </tr>
                    <tr>
                        <th scope="row">Last 6 Months</th>
                        <td class="currency-amount currency-positive">&pound; 512.45</td>
                        <td class="currency-amount currency-positive">&pound; 72.24</td>
                        <td style="text-align: center">26</td>
                        <td style="text-align: center">5.87 &percnt;</td>
                    </tr>
                    <tr>
                        <th scope="row">Last Year</th>
                        <td class="currency-amount currency-positive">&pound; 1652.54</td>
                        <td class="currency-amount currency-positive">&pound; 78.84</td>
                        <td style="text-align: center">51</td>
                        <td style="text-align: center">7.54 &percnt;</td>
                    </tr>
                    <tr>
                        <th scope="row">All Available Records</th>
                        <td class="currency-amount currency-positive">&pound; 2585.54</td>
                        <td class="currency-amount currency-positive">&pound; 85.54</td>
                        <td style="text-align: center">56</td>
                        <td style="text-align: center">7.57 &percnt;</td>
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
    name: "regular-table",
    props: [
        'source',
        'name',
        'period'
    ],
    computed: {
        regularsLoaded: function () {
            return this.$store.state.regularsLoaded;
        }
    },
    methods: {
        onChangePage: function (page) {
            // let limit = this.$store.state.latestRegularTableStats.limit;
            this.loadPage(page, limit);
        },
        onChangeLimit: function (limit) {
            this.loadPage(1, limit);
        },
        async loadPage(page = 1, limit = 25) {
            let url = `/regulars/possible-new`;
            this.$store.commit('regularsLoaded', false);
            const returnedData = await axios.get(url);
            // console.dir(returnedData);
            this.$store.commit('updateLatestregularTableData', returnedData.data.data);
            this.$store.commit('updateLatestregularTableStats', returnedData.data.stats);
            this.$store.commit('regularsLoaded', true);
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
