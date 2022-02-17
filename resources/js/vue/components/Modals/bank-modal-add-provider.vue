<template>
    <bank-modal-base id="add-provider-modal">
        <template v-slot:modal-header>
            Add a new Provider
        </template>

        <template v-slot:modal-body>
            <form id="add-provider-form">
                <div class="mb-3">
                    <label for="provider-name" class="form-label">Provider Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="provider-name"
                        aria-describedby="provider-name-help"
                        placeholder="eg Asda"
                        v-model="providerName"
                    >
                    <div id="provider-name-help" class="form-text">What is the name of the Provider?</div>
                </div>

                <div class="mb-3">
                    <label for="text-entries" class="form-text">Text Entries</label>
                    <textarea
                        class="form-control"
                        id="text-entries"
                        aria-describedby="text-entries-help"
                        placeholder="eg Halifax Mortgage"
                        v-model="textEntries"
                    ></textarea>
                    <div id="text-entries-help" class="form-text">List any entries that you'd to automatically associate with this provider</div>
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <input
                        type="text"
                        class="form-control"
                        id="remarks"
                        v-model="remarks"
                    >
                    <div id="remarks-help" class="form-text">Is there anything you want to add about this provider?</div>
                </div>

                <div class="mb-3">
                    <label for="payment-method" class="form-label">Preferred Payment Method</label>
                    <select
                        class="form-control"
                        id="payment-method"
                        name="payment-method"
                        v-model="paymentMethod"
                    >
                        <option v-for="method in paymentMethods" :key="method.id" :value="method.id">{{ method.method }}</option>
                    </select>
                    <div id="payment-method-help" class="form-text">What is the payment method this provider likes to use?</div>
                </div>
            </form>
        </template>

        <template v-slot:modal-footer>
            <button
                aria-label="Cancel and dismiss the add provider modal"
                class="btn btn-warning"
                data-bs-dismiss="modal"
                type="button"
                @click="dismissModal"
            >Cancel</button>

            <button
                aria-label="Cancel and dismiss the add provider modal"
                class="btn btn-primary"
                form="add-provider-form"
                id="add-provider-submit-button"
                type="button"
                @click="submit"
            >Add provider</button>

            <button
                aria-label="Submit the form and associate the chosen provider with the parent item eg transaction, then search for similar transactions"
                class="btn btn-secondary"
                form="add-provider-form"
                id="add-provider-and-search-submit-button"
                type="button"
                @click="submitAndSearch"
            >Add &amp; look for others
            </button>
        </template>
    </bank-modal-base>
</template>

<script>
const bootstrap = require('bootstrap');

export default {
    name: "bank-modal-add-provider",
    data() {
        return {
            ajaxProviderData: null,
            ajaxUrl: `/providers/store-from-js`,
            findSimilar: false,
            providerName: '',
            remarks: '',
            textEntries: '',
            paymentMethod: 16, // @todo I need to ensure that the correct method is default
        }
    },
    computed: {
        paymentMethods: function() {
            return this.$store.state.paymentMethods;
        }
    },
    methods: {
        async submit (event) {
            if (0 === this.providerName.length) return;

            this.disableSubmitButton();
            const ajaxData = {
                find_similar: (this.findSimilar) ? 1 : 0,
                name: this.providerName,
                payment_method_id: this.paymentMethod,
                regular_expressions: this.textEntries,
                remarks: this.remarks,
                transaction_id: this.$store.state.modalTransactionId,
                type: 'json'
            };

            const returnedData = await axios.post(this.ajaxUrl, ajaxData);

            this.resetForm();
            window.addProviderModal.hide();

            if (returnedData.status === 201) {
                const providerId = returnedData.data.provider_id;
                this.providerSuccessfullyAdded({
                    id: providerId,
                    name: returnedData.data.provider_name,
                    similarTransactions: returnedData.data.similar_transactions
                });

                if (this.findSimilar === true) {
                    this.showSimilar(returnedData.data.similar_transactions, providerId);
                }
            } else {
                console.groupCollapsed('"Submit" action failed')
                console.log('Status: ', returnedData.status);
                console.info('Reply...');
                console.log(returnedData.data);
                console.info('Headers...');
                console.log(returnedData.headers);
                console.groupEnd();

                this.$store.commit('newProviderDetected', this.providerName);
                Toast.fire({title: "Provider Added", icon: "success"})
            }
        },
        dismissModal: function () {
            this.resetForm();
            window.addProviderModal.dispose();
        },
        enableSubmitButton () {
            document.getElementById("add-provider-submit-button").removeAttribute("disabled")
        },
        disableSubmitButton () {
            document.getElementById("add-provider-submit-button").setAttribute("disabled", "disabled");
        },
        submitAndSearch: function (event) {
            this.findSimilar = true;
            this.submit(event);
        },
        resetForm () {
            this.providerName = '';
            this.remarks = '';
            this.textEntries = '';
            this.paymentMethod = '---';
            this.enableSubmitButton();
        },
        showSimilar: function (similar, providerId) {
            if (similar.length === 0) {
                Toast.fire({
                    icon: 'info',
                    title: "There are no similar transactions"
                });
            } else {
                this.$store.commit('updateSimilarTransactions', similar);
                this.$store.commit('updateSimilarTransactionsEntityId', providerId);
                this.$store.commit('updateSimilarTransactionsType', 'provider');
                window.addSimilarTransactionsModal.show()
            }
        },
        providerSuccessfullyAdded: function (providerDetails) {
            this.$store.commit('updateNewEntityDetails', {
                id: providerDetails.id,
                name: providerDetails.name,
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
                window.addProviderModal.hide();
                console.log('Payment Method error: ', returnedData.data);
            }
        }
    },
    mounted () {
        if (this.$store.state.paymentMethods.length === 0) {
            this.updateMethods();
        }

        window.addProviderModal = new bootstrap.Modal(document.getElementById('add-provider-modal'))
    }
}
</script>
