<template>
    <modal id="add-similar-transactions-modal">
        <template v-slot:modal-header>
            Add similar transactions?
        </template>

        <template v-slot:modal-body>
            <form id="similar-transactions-form" class="similar-transactions-form">
                <div class="mb-3">
                    <label for="add-similar-transactions-select" class="form-label">Similar Transactions</label>

                    <select
                        name="add-similar-transactions-select"
                        id="add-similar-transactions-select"
                        multiple="multiple"
                        class="col-md-12"
                        v-model="otherTransactions">
                        <option v-for="transaction in similarTransactions" :key="transaction.id" :value="transaction.id" class="similar-transactions-option">
                            <span class="option-date">{{ formatDate(transaction.date) }}</span>
                            <span class="option-amount">{{ formatCurrency(transaction.amount) }}</span>
                            <span class="option-entry">{{ transaction.entry }}</span>
                            <span class="option-remarks">{{ formatRemarks(transaction.remarks) }}</span>
                        </option>
                    </select>
                    <div id="similar-transactions-help" class="form-text">
                        You can also apply the new tag to these transaction<br />
                        Click this link to select the similar transactions shown above.</div>
                </div>
            </form>
        </template>

        <template v-slot:modal-footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" form="similar-transactions-form" @click="addTransactions" id="add-similar-transactions-button">Associate Transactions</button>
        </template>
    </modal>
</template>

<script>
const bootstrap = require('bootstrap');
const { currency, formatDate } = require("../../helperFunctions");

export default {
    name: "add-similar-transactions-modal",
    data () {
        return {
            otherTransactions: []
        }
    },
    computed: {
        similarTransactions () {
            return this.$store.state.similarTransactions;
        }
    },
    methods: {
        formatRemarks: function (remark) {
            if (null === remark) {
                remark = '';
            }
            return remark.substr(0,25);
        },
        async addTransactions () {
            this.disableSubmitButton();
            const url = `/tags/assignTransactions`;
            const returnedData = await axios.post(url, {
                tag: this.$store.state.similarTransactionsTagId,
                transactions: this.otherTransactions,
                type: 'json'
            });

            const assignedTransactions = returnedData.data.assignedTransactions;
            const errors               = returnedData.data.errors;
            const failedTransactions   = returnedData.data.failedTransactions;
            const tagDetails           = returnedData.data.tagDetails;

            if (returnedData.status === 202) {
                this.assignSuccessfulTransactions(assignedTransactions, tagDetails);
                Toast.fire({ title: "Transactions Updated", icon: "success" });
            } else if (returnedData.status === 206) {
                // mixed content. so some have files
                this.assignSuccessfulTransactions(assignedTransactions, tagDetails);
                this.assignFailedTransactions(failedTransactions, errors);
                Toast.fire({ title: "Mixed result: see the log", icon: "warning" });
            } else {
                this.assignFailedTransactions(failedTransactions, errors);
                Toast.fire({ title: "It didn't work :-( see the log", icon: "error" });
            }
            this.resetForm();
            window.addSimilarTransactionsModal.hide()
        },
        assignFailedTransactions: function (failedTransactions, errors) {
            console.groupCollapsed('Failed Transaction Updates')
            console.info('Failed Transactions');
            console.dir(failedTransactions);
            console.info('Errors');
            console.dir(errors);
            console.groupEnd();
        },
        assignSuccessfulTransactions: function (assignedTransactions, tagDetails) {
            const newItem = {
                icon: tagDetails.icon,
                tag: tagDetails.name,
                id: tagDetails.id,
                default_color: tagDetails.default_color,
                contrasted_color: tagDetails.contrasted_color
            };
            let rows = this.$parent.$children[0].$children[2].$refs['transaction-table-tags-list-row'];
            for (let i=0; i<rows.length; i++) {
                let row = rows[i];
                let id = row.$options.propsData.row.id;
                let exists = assignedTransactions.includes(id);
                if (exists) {
                    row.$options.propsData.row.tags.push(newItem);
                }
            }
        },
        enableSubmitButton () {
            document.getElementById("add-similar-transactions-button").removeAttribute("disabled")
        },
        disableSubmitButton () {
            document.getElementById("add-similar-transactions-button").setAttribute("disabled", "disabled");
        },
        resetForm () {
            this.$store.commit('updateSimilarTransactions', null)
            this.enableSubmitButton();
        },
        formatCurrency: amount => currency(amount),
        formatDate: date => formatDate(date)
    },
    mounted () {
        window.addSimilarTransactionsModal = new bootstrap.Modal(document.getElementById('add-similar-transactions-modal'))
    }
}
</script>

<style lang="scss">
.similar-transactions-form {
    label {
        display: block;
    }

    select { font-size: 0.8rem; }

    .similar-transactions-option {
        display: flex;
        flex-direction: row;

        &:hover {
            background-color: #cccccc;
        }
    }

    .option-date {
        width: 7rem;
        flex-grow: 1;
    }

    .option-amount {
        width: 6rem;
        flex-grow: 1;
    }

    .option-entry {
        width: 10rem;
        flex-grow: 1.25;
    }

    .option-remarks {
        width: 10rem;
        flex-grow: 3;
    }
}
</style>
