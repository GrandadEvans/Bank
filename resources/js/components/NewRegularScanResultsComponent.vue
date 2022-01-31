<template>
    <div v-if="possibleNewRegularsLoaded === true">
        <regular-table></regular-table>
    </div>
</template>

<script>
export default {
    name: "new-regular-scan-results-table",
    props: ['source'],
    computed: {
        possibleNewRegularsLoaded: function () {
            return this.$store.state.possibleNewRegularsLoaded;
        }
    },
    methods: {
        onChangePage: function (page) {
            // let limit = this.$store.state.latestRegularTableStats.limit;
            // this.loadPage(page, limit);
        },
        onChangeLimit: function (limit) {
            this.loadPage(1, limit);
        },
        async loadPage(page = 1, limit = 25) {
            let url = `/regulars/possible-new`;
            this.$store.commit('possibleNewRegularsLoaded', false);
            const returnedData = await axios.get(url);
            this.$store.commit('updateLatestRegularTableData', returnedData.data.data);
            this.$store.commit('updateLatestRegularTableStats', returnedData.data.stats);
            this.$store.commit('possibleNewRegularsLoaded', true);
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
