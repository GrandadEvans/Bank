<template>
    <bank-modal-base id="add-remarks-modal">
        <template v-slot:modal-header>
            Add a remark
        </template>

        <template v-slot:modal-body>
            <form id="add-remark-form" aria-label="This form allows you to add a new remark" @submit.prevent="submit">
                <div class="mb-3" aria-label="This is the remark that is to be edited">
                    <label for="remark" class="form-label">Remark</label>
                    <input
                        aria-describedby="remark-help"
                        class="form-control"
                        id="remark"
                        name="remark"
                        placeholder="What else do you want to memorialise?"
                        type="text"
                        v-model="remark"
                        data-cy="modal-remark-edit"
                    />
                    <div id="remark-help" class="form-text">
                        <p>This field will allow you to add additional information to the item, eg transaction.</p>
                    </div>
                </div>
            </form>
        </template>

        <template v-slot:modal-footer>
            <button
                aria-label="Cancel and dismiss the add remark modal"
                class="btn btn-warning"
                data-bs-dismiss="modal"
                data-cy="modal-remark-cancel"
                type="button"
                @click="dismissModal"
            >Cancel
            </button>

            <button
                aria-label="Submit the form and associate the chosen remark with the parent item eg transaction"
                class="btn btn-primary"
                form="add-remark-form"
                id="add-remark-submit-button"
                type="submit"
                data-cy="modal-remark-submit"
            >Add remark
            </button>
        </template>
    </bank-modal-base>
</template>

<script>
const bootstrap = require('bootstrap');

export default {
    name: "bank-modal-add-remarks",
    data() {
        return {
            remark: '',
            ajaxUrl: '/transactions/add-remark-from-js',
        }
    },
    computed: {
        transactionId: function () {
            return this.$store.state.modalTransactionId
        },
        allFieldsSet () {
            return (null != this.remark);
        },
    },
    methods: {
        async submit (event) {
            if (0 === this.remark.length) return;

            this.disableSubmitButton();

            const ajaxData = {
                transaction_id: this.transactionId,
                remark: this.remark
            };

            const returnedData = await axios.patch(this.ajaxUrl, ajaxData);

            if (returnedData.status === 201) {
                let data = returnedData.data;
                let allTransactions = this.$store.state.latestTransactionTableData;
                for(let i=0; i < allTransactions.length; i++) {
                    if (allTransactions[i].id == this.transactionId) {
                        if (this.remark === data.transaction.remark) {
                            allTransactions[i].remark = this.remark;
                            this.$store.commit('updateLatestTransactionTableData', allTransactions);
                            document.getElementById(`transaction-${this.transactionId}-remark`).innerText = this.remark;
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'There was an error updating the remark'
                            });
                        }
                    }
                }
            } else {
                console.groupCollapsed('"Submit" action failed')
                console.log('Status: ', returnedData.status);
                console.info('Reply...');
                console.log(returnedData.data);
                console.info('Headers...');
                console.log(returnedData.headers);
                console.groupEnd();
            }

            this.resetForm();
            window.addRemarksModal.hide();
        },
        dismissModal: function () {
            this.resetForm();
            window.addRemarksModal.hide();
        },
        disableSubmitButton () {
            document.getElementById("add-remark-submit-button").setAttribute("disabled", "disabled");
        },
        enableSubmitButton () {
            document.getElementById("add-remark-submit-button").removeAttribute("disabled")
        },
        resetForm () {
            this.remark = null;
            this.$store.commit('updateModalTransactionId', null)
            this.enableSubmitButton();
        },
    },
    mounted () {
        window.addRemarksModal = new bootstrap.Modal(document.getElementById('add-remarks-modal'))
        var modal = document.getElementById('add-remarks-modal')
        var input = document.getElementById('remark')

        modal.addEventListener('shown.bs.modal', function () {
            input.focus()
            input.select();
        })
    }
}
</script>
