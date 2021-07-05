<template>
    <tbody>
        <transaction-table-row
            v-for="(rowData, index) in transactionsList"
            :row="rowData"
            :index="index"
            :key="rowData.id"
            :ref="'transaction-table-tags-list-row'"
        />

    </tbody>
</template>

<script>
export default {
    name: "transaction-table-body",
    computed: {
        transactionsList: function() {
            return this.$store.state.latestTransactionTableData;
        },
    }
}
</script>

<style>
</style>
