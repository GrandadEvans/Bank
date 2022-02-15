<template>
    <thead>
    <tr>
        <th v-for="column in this.regularTable" scope="col">{{ column.label }}</th>
    </tr>
    </thead>
</template>

<script>
export default {
    name: "regular-table-header",
    props: ['returnedData'],
    computed: {
        regularTable: function () {
            return this.$store.state.regularTable;
        }
    }
}
</script>

<style>
</style>
