<template>
    <tfoot>
    <tr>
        <td :colspan="columns_count">Showing records {{ startingRecord }} to {{ endRecord }} of {{ totalRecords }}</td>
    </tr>
    </tfoot>
</template>

<script>
export default {
    name: "regular-table-footer",
    computed: {
        totalRecords: function () {
            return this.$store.state.latestRegularTableStats.totalRecords;
        },
        startingRecord: function () {
            return this.$store.state.latestRegularTableStats.startingRecord;
        },
        endRecord: function () {
            return this.$store.state.latestRegularTableStats.endRecord;
        },
        columns_count: function () {
            return this.$store.state.regularTable.length;
        }
    },
}
</script>

<style>
</style>
