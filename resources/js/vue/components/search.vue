<template>
    <div class="row">
        <div class="container">
            <form class="mb-6 offset-6">
                <div class="input-group">
                    <span class="input-group-text" id="search-input-icon">@</span>
                    <input
                        aria-label="Search term"
                        aria-describedby="search-help"
                        class="form-control"
                        id="search-input"
                        type="search"
                        placeholder="What do you want to search for?"
                        v-model="search"
                        @keyup="getResults"
                    >
                </div>
                <div id="search-help" class="form-text">
                    <p>
                        Use this search field to filter the transactions using the transaction text.<br />
                        Top Tip: You can filter by provider by prepending the search term with "@provider" or ":provider"
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "search",
    data: function () {
        return {
            search: '',
            previousTransactions: this.$store.state
        }
    },
    props: [
    ],
    computed: {},
    methods: {
        async getResults () {
            if (this.search.length < 3) return;

            this.$store.commit('transactionsLoaded', false);
            const results = await axios.post('/search', {
                term: this.search
            });

            // console.log(results);

            if (results.status === 200) {
                this.$store.commit('updateLatestTransactionTableData', results.data.data);
                this.$store.commit('updateLatestTransactionTableStats', results.data.stats);
                this.$store.commit('transactionsLoaded', true);
            } else {
                Toast.fire({
                    icon: 'error',
                    text: 'Unable to perform the search'
                })
            }
        }
    }
}
</script>

<style lang="scss"></style>
