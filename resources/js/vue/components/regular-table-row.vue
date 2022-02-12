<template>
    <tr :class="significantEntry(row.amount)">
        <td>
            <td-date :date="row.date"/>
        </td>
        <td>
            <td-provider
                v-if="row.provider.name === 'N/A'"
                :transaction_id="row.id"
            ></td-provider>

            <td-provider
                v-else
                :transaction_id="row.id"
                v-on:db-click="dbClickProvider"
            >{{ row.provider.name }}
            </td-provider>
        </td>
        <td>
            <td-amount :amount="row.amount"/>
        </td>
        <td>
            <td-payment-method :method="row.payment_method"/>
        </td>
        <td class="limit-cell-width text-truncate" @dblclick="editRemark">{{ row.remarks }}</td>
    </tr>
</template>

<script>
export default {
    name: "regular-table-row",
    props: [
        'row',
        'index'
    ],
    data: function () {
        return {
            mode: 'list'
        }
    },
    methods: {
        significantEntry: (amount) => {
            if (amount < -500) {
                return "table-danger";
            } else if (amount > 500) {
                return "table-success";
            } else {
                return "";
            }
        },
        dbClickProvider: function () {
            this.row.provider.name = 'N/A';
        },
    },
}
</script>

<style lang="scss">
.transactions-table > tr {
    vertical-align: middle;
}

.limit-cell-width {
    $max-width: 15rem;
    max-width: $max-width;
}
</style>
