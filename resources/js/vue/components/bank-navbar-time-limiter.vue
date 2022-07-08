<template>
    <nav>
        <div>
            <p>Limit the results to a preset period...
            <select name="set-periods">
                <option name="unset" v-on:click="$emit('limit-period', 'unset')">Show me them all</option>
                <option name="year" v-on:click="$emit('limit-period', 'year')">Year</option>
                <option name="month" v-on:click="$emit('limit-period', 'month')">Month</option>
                <option name="week" v-on:click="$emit('limit-period', 'week')">Week</option>
            </select>
            </p>
        </div>
    </nav>
</template>

<script>
export default {
    name: "bank-navbar-time-limiter",
    computed: {},
    methods: {
        updateTransactions: function () {
            this.$emit('limitTransactionsByDate', [])
        },
    },
    data: function () {
        return {}
    },
    props: {

    }
}
</script>
