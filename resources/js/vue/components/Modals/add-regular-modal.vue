<template>
    <modal-base id="add-regular-modal">
        <template v-slot:modal-header>
            Add a new Regular
        </template>

        <template v-slot:modal-body>
            <form id="add-regular-form">
                <!-- Alias -->
                <div class="mb-3 form-floating">
                    <label for="regular-alias" class="form-label">Regular Alias</label>
                    <input
                        type="text"
                        class="form-control"
                        id="regular-alias"
                        aria-describedby="regular-alias-help"
                        placeholder="eg Home Insuarance"
                        v-model="regularAlias"
                    >
                    <div id="regular-alias-help" class="form-text">
                        You can give this regular payment an alias that
                        makes it easier to recognise in the transactions list?
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-3 form-floating">
                    <label for="regular-amount" class="form-label">Regular Amount</label>
                    <input
                        type="text"
                        class="form-control"
                        id="regular-amount"
                        aria-describedby="regular-amount-help"
                        placeholder="eg £12.34"
                        v-model="regularDetails.amount"
                    >
                    <div id="regular-amount-help" class="form-text">
                        Is there a set amount that this regular transaction should be?
                    </div>
                </div>

                <!-- Estimated -->
                <div class="mb-3">
                    <label for="regular-variable-amount" class="form-label">Variable Amount?</label>
                    <select
                        class="form-control"
                        id="regular-variable-amount"
                        aria-describedby="regular-variable-amount-help"
                        v-model="regularVariableAmount"
                    >
                        <option value="false">Set Amount</option>
                        <option value="true">Variable Amount</option>
                    </select>
                    <div id="regular-variable-amount-help" class="form-text">
                        Is the amount of this regular transaction set or can it be a variable amount
                    </div>
                </div>

                <!-- Next due date -->
                <div class="mb-3">
                    <label for="regular-next-due" class="form-label">Date next due</label>
                    <input
                        type="date"
                        class="form-control"
                        id="regular-next-due"
                        aria-describedby="regular-next-due-help"
                        placeholder="31/01/2022"
                        v-model="regularDetails.date"
                    >
                    <div id="regular-next-due-help" class="form-text">
                        What is the date the next transaction is due to be deducted?
                    </div>
                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label for="regular-remarks" class="form-text">Remarks</label>
                    <textarea
                        class="form-control"
                        id="regular-remarks"
                        aria-describedby="regular-remarks-help"
                        placeholder="eg Due for renewal May 21st"
                        v-model="regularRemarks"
                    ></textarea>
                    <div id="regular-remarks-help" class="form-text">
                        Here you can put any other information you would like to note on this regular payment
                    </div>
                </div>

                <!-- Payment method -->
                <div class="mb-3">
                    <label for="regular-payment-method" class="form-label">Preferred Payment Method</label>
                    <select
                        class="form-control"
                        id="regular-payment-method"
                        name="regular-payment-method"
                        v-model="regularDetails.payment_method_id"
                    >
                        <option v-for="method in paymentMethods" :key="method.id" :value="method.id">{{
                                method.method
                            }}
                        </option>
                    </select>
                    <div id="regular-payment-method-help" class="form-text">What is the payment method this regular
                        likes to
                        use?
                    </div>
                </div>

                <!-- Provider -->
                <div class="mb-3">
                    <label for="regular-provider" class="form-label">Associated Provider</label>
                    <select
                        class="form-control"
                        id="regular-provider"
                        name="regular-provider"
                        v-model="regularDetails.provider_id"
                    >
                        <option v-for="provider in providers" :key="provider.id" :value="provider.id">{{
                                provider.name
                            }}
                        </option>
                    </select>
                    <div id="regular-provider-help" class="form-text">Please select a default service or goods provider
                        for this
                        new regular transaction.<br/>Alternatively, you can select to create a new provider
                    </div>
                </div>
            </form>

        </template>

        <template v-slot:modal-footer>
            <button
                aria-label="Cancel and dismiss the add regular transaction modal"
                class="btn btn-warning"
                data-bs-dismiss="modal"
                type="button"
                @click="dismissModal"
            >Cancel
            </button>

            <button
                aria-label="Cancel and dismiss the add regular transaction modal"
                class="btn btn-primary"
                form="add-regular-form"
                id="add-regular-submit-button"
                type="button"
                @click="submit"
            >Add Regular Transaction
            </button>
        </template>
    </modal-base>
</template>

<script>
const bootstrap = require('bootstrap');

export default {
    name: "add-regular-modal",
    data() {
        return {
            ajaxRegularData: null,
            ajaxUrl: `/regulars/store-from-js`,
            regularAlias: '',
            regularRemarks: '',
            regularAmount: 0,
            regularVariableAmount: false,
            regularProvider: null,
            regularPaymentMethod: null,
            regularNextDue: null,
        }
    },
    computed: {
        paymentMethods: function () {
            return this.$store.state.paymentMethods;
        },
        providers: function () {
            return this.$store.state.providersData;
        },
        regularDetails: function () {
            if (this.$store.state.newRegularDetailsLoaded === false) {
                return {
                    amount: 0,
                    provider_id: null,
                    payment_method_id: null,
                    date: null
                };
            } else {
                return this.$store.state.newRegularDetails;
            }
        }
    },
    methods: {
        async submit(event) {
            if (0 === this.regularAlias.length) return;

            this.disableSubmitButton();
            const ajaxData = {
                find_similar: (this.findSimilar) ? 1 : 0,
                name: this.regularName,
                payment_method_id: this.paymentMethod,
                regular_expressions: this.textEntries,
                remarks: this.remarks,
                transaction_id: this.$store.state.modalTransactionId,
                type: 'json'
            };

            const returnedData = await axios.post(this.ajaxUrl, ajaxData);

            this.resetForm();
            window.addRegularModal.hide();

            if (returnedData.status === 201) {
                const regularId = returnedData.data.regular_id;
                this.regularSuccessfullyAdded({
                    id: regularId,
                    name: returnedData.data.regular_name,
                    // similarTransactions: returnedData.data.similar_transactions
                });

                if (this.findSimilar === true) {
                    this.showSimilar(returnedData.data.similar_transactions, regularId);
                }
            } else {
                console.groupCollapsed('"Submit" action failed')
                console.log('Status: ', returnedData.status);
                console.info('Reply...');
                console.log(returnedData.data);
                console.info('Headers...');
                console.log(returnedData.headers);
                console.groupEnd();
                this.$store.commit('newRegularDetected', this.regularName);
                Toast.fire({title: "Regular Added", icon: "success"})
            }
        },
        dismissModal: function () {
            this.resetForm();
            window.addRegularModal.dispose();
        },
        enableSubmitButton() {
            document.getElementById("add-regular-submit-button").removeAttribute("disabled")
        },
        disableSubmitButton() {
            document.getElementById("add-regular-submit-button").setAttribute("disabled", "disabled");
        },
        submitAndSearch: function (event) {
            this.findSimilar = true;
            this.submit(event);
        },
        resetForm() {
            this.regularName = '';
            this.remarks = '';
            this.textEntries = '';
            this.paymentMethod = '---';
            this.enableSubmitButton();
        },
        showSimilar: function (similar, regularId) {
            if (similar.length === 0) {
                Toast.fire({
                    icon: 'info',
                    title: "There are no similar transactions"
                });
            } else {
                this.$store.commit('updateSimilarTransactions', similar);
                this.$store.commit('updateSimilarTransactionsEntityId', regularId);
                this.$store.commit('updateSimilarTransactionsType', 'regular');
                this.$store.commit('updateSimilarTransactionsRowRef',
                    this.$parent.$children[0].$children[2].$refs['transaction-table-entitys-list-row']);
                window.addSimilarTransactionsModal.show()
            }
        },
        regularSuccessfullyAdded: function (regularDetails) {
            this.$store.commit('updateNewEntityDetails', {
                id: regularDetails.regular_id,
                name: regularDetails.name,
            });
        },
        async updateMethods() {
            const url = '/payment_methods/all';
            const returnedData = await axios.get(url);

            if (returnedData.status === 200) {
                this.$store.commit('updatePaymentMethods', returnedData.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Could not get the latest payment methods',
                });
                window.addRegularModal.hide();
                console.log('Payment Method error: ', returnedData.data);
            }
        }
    },
    mounted() {
        if (this.$store.state.paymentMethods.length === 0) {
            this.updateMethods();
        }

        window.addRegularModal = new bootstrap.Modal(document.getElementById('add-regular-modal'))
    }
}
</script>
