<template>
    <tr :class="significantEntry(row.amount)" :data-transaction-id="row.id">
        <th>{{ row.id }}</th>
        <td><input type="checkbox"/></td>
        <td>
            <td-date :date="row.date"/>
        </td>
        <td>
            <td-provider
                v-if="row.provider.name === 'N/A'"
                :transaction="row"
            ></td-provider>

            <td-provider
                v-else
                :transaction="row"
                v-on:db-click="dbClickProvider"
            >{{ row.provider.name }}</td-provider>
        </td>
        <td>{{ row.entry }}</td>
        <td><td-amount :amount="row.amount"/></td>
        <td><td-amount :amount="row.balance"/></td>
        <td><td-payment-method :method="row.payment_method"/></td>
        <td data-cy="tags-list" v-on:dblclick="changeTagMode">
            <tags-list
                :index="index"
                :mode="mode"
                :tags="row.tags"
                :transaction_id="row.id"
                v-on:change-tag-mode="changeTagMode"
                v-on:tag-deleted="tagDeleted"
            /></td>
        <td class="limit-cell-width text-truncate" @dblclick="editRemark" data-cy="transaction-row-remarks">{{ row.remarks }}</td>
        <td>EDIT</td>
    </tr>
</template>

<script>
export default {
    name: "transaction-table-row",
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
        editRemark: function() {
            this.$store.commit('updateModalTransactionId', this.row.id);
            window.addRemarksModal.show();
            document.getElementById('remark').value = this.row.remarks;
        },
        changeTagMode: function () {
            this.mode = (this.mode === 'list') ? 'edit' : 'list';
        },
        tagDeleted: function (index) {
            this.row.tags.splice(index, 1)
        }
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
