<template>
    <tbody>
    <regular-table-row
        v-for="(rowData, index) in regularsList"
        :row="rowData"
        :index="index"
        :key="rowData.id"
    />

    </tbody>
</template>

<script>
export default {
    name: "regular-table-body",
    computed: {
        regularsList: function () {
            return this.$store.state.latestRegularTableData;
        },
    }
}
</script>

<style>
</style>
