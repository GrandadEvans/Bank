<template>
    <thead>
            <tr>
                <th v-for="column in this.transactionTable" scope="col">{{ column.label }}</th>
            </tr>
    </thead>
</template>

<script>
export default {
    name: "transaction-table-header",
    props: ['returnedData'],
    computed: {
        transactionTable: function () {
            return this.$store.state.transactionTable;
        }
    }
}
</script>

<style>
</style>
