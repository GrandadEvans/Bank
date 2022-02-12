<template>
    <tfoot>
        <tr>
            <td :colspan="columns_count">Showing records {{ startingRecord }} to {{ endRecord}} of {{ totalRecords }}</td>
        </tr>
    </tfoot>
</template>

<script>
    export default {
        name: "transaction-table-footer",
        computed: {
            totalRecords: function () {
                return this.$store.state.latestTransactionTableStats.totalRecords;
            },
            startingRecord: function () {
                return this.$store.state.latestTransactionTableStats.startingRecord;
            },
            endRecord: function () {
                return this.$store.state.latestTransactionTableStats.endRecord;
            },
            columns_count: function () {
                return this.$store.state.transactionTable.length;
            }
        },
    }
</script>

<style>
</style>
