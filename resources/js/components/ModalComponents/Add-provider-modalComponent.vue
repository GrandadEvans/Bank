<template>
    <modal id="add-provider-modal">
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" form="add-provider-form" @click="addProvider" id="add-provider-submit-button">Add provider</button>
        </template>
    </modal>
</template>

<script>
const bootstrap = require('bootstrap');

export default {
    name: "add-provider-modal",
    data () {
        return {
            providerName: '',
            remarks: '',
            textEntries: '',
            paymentMethod: 16,
        }
    },
    computed: {
        paymentMethods: function() {
            return this.$store.state.paymentMethods;
        }
    },
    methods: {
        async addProvider () {
            this.disableSubmitButton();
            const url = `/providers/store-from-js`;
            const returnedData = await axios.post(url, {
                name: this.providerName,
                remarks: this.remarks,
                regular_expressions: this.textEntries,
                payment_method_id: this.paymentMethod,
                transaction_id: this.$store.state.modalTransactionId,
                type: 'json'
            });

            if (returnedData.status === 201) {
                this.$store.commit('newProviderDetected', this.providerName);
                this.resetForm();
                window.addProviderModal.hide();
                Toast.fire({title: "Provider Added", icon: "success"})
            }
        },
        enableSubmitButton () {
            document.getElementById("add-provider-submit-button").removeAttribute("disabled")
        },
        disableSubmitButton () {
            document.getElementById("add-provider-submit-button").setAttribute("disabled", "disabled");
        },
        resetForm () {
            this.providerName = '';
            this.remarks = '';
            this.textEntries = '';
            this.paymentMethod = 'Unknown';
            this.enableSubmitButton();
        },
        async updateMethods() {
            const url = '/payment_methods/all';
            const returnedData = await axios.get(url);

            if (returnedData.status === 200) {
                this.$store.commit('updatePaymentMethods', returnedData.data);
                console.log(this.$store.state.paymentMethods);
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
