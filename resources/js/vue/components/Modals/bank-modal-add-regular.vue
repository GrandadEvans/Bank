<template>
    <bank-modal-base id="add-regular-modal">
        <template v-slot:modal-header>
            Add a new Regular
        </template>

        <template v-slot:modal-body>
            <form id="add-regular-form">
                <!-- Entry -->
                <div class="mb-3">
                    <label for="regular-entry" class="form-label">Entry text</label>
                    <div class="input-group">
                        <input
                            aria-describedby="regular-entry-help"
                            aria-label="Disabled input example"
                            aria-required="true"
                            class="form-control"
                            disabled="disabled"
                            id="regular-entry"
                            readonly="readonly"
                            required="required"
                            type="text"
                            value="Disabled readonly input"
                            v-model="regularDetails.entry"
                        >
                        <button
                            class="btn btn-outline-secondary"
                            id="button-copy-entry-to-alias"
                            @click.stop.prevent="copyEntryToAlias"
                        >
                            <font-awesome-icon icon="fa-arrow-down"/>
                            Copy to <strong>Alias</strong>
                            <font-awesome-icon icon="fa-arrow-down"/>
                        </button>
                    </div>
                    <div id="regular-entry-help" class="form-text">
                        <p>
                            This is the text that is show in your banking app, or your bank statement etc. You are not
                            able to alter this as it is what the <abbr title="Artificial Intelligence">AI</abbr> will
                            look for in future entries.
                        </p>
                    </div>
                </div>

                <!-- Alias -->
                <div class="mb-3">
                    <label for="regular-alias" class="form-label" data-required="true">Regular Alias</label>
                    <input
                        type="text"
                        class="form-control"
                        id="regular-alias"
                        aria-describedby="regular-alias-help"
                        placeholder="eg Home Insuarance"
                        required="required"
                        aria-required="true"
                        v-model="regularDetails.alias"
                    >
                    <div id="regular-alias-help" class="form-text">
                        <p>
                            You can give this regular payment an alias that makes it easier to recognise in the
                            transactions list?
                        </p>
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-3">
                    <label for="regular-amount" class="form-label">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">&pound;</span>
                        <input
                            type="text"
                            class="form-control"
                            id="regular-amount"
                            aria-describedby="regular-amount-help"
                            aria-required="false"
                            placeholder="eg 12.34"
                            v-model="regularDetails.amount"
                        >
                    </div>
                    <div id="regular-amount-help" class="form-text">
                        <p>
                            Is there a set amount that this regular transaction should be?
                        </p>
                    </div>
                </div>

                <!-- Next due date -->
                <div class="mb-3">
                    <label for="regular-next-due" class="form-label" data-required="true">Date next due</label>
                    <input
                        type="date"
                        class="form-control"
                        id="regular-next-due"
                        aria-describedby="regular-next-due-help"
                        aria-required="true"
                        required="required"
                        placeholder="31/01/2022"
                        v-model="regularDetails.date"
                    >
                    <div id="regular-next-due-help" class="form-text">
                        <p>
                            What is the date the next transaction is due to be deducted?
                        </p>
                    </div>
                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label for="regular-remarks" class="form-text">Remarks</label>
                    <textarea
                        class="form-control"
                        id="regular-remarks"
                        aria-describedby="regular-remarks-help"
                        aria-required="false"
                        placeholder="eg Due for renewal May 21st"
                        v-model="regularDetails.remarks"
                    ></textarea>
                    <div id="regular-remarks-help" class="form-text">
                        <p>
                            Here you can put any other information you would like to note on this regular payment
                        </p>
                    </div>
                </div>

                <!-- Payment method -->
                <div class="mb-3">
                    <label for="regular-payment-method" class="form-label" data-required="true">Preferred Payment
                        Method</label>
                    <select
                        class="form-select"
                        id="regular-payment-method"
                        name="regular-payment-method"
                        required="required"
                        aria-required="true"
                        v-model="regularDetails.payment_method_id"
                    >
                        <option v-for="method in paymentMethods" :key="method.id" :value="method.id">{{
                                method.method
                            }}
                        </option>
                    </select>
                    <div id="regular-payment-method-help" class="form-text">
                        <p>
                            What is the payment method this regular likes to use?
                        </p>
                    </div>
                </div>

                <!-- Provider -->
                <div class="mb-3">
                    <label for="regular-provider" class="form-label" data-required="true">Associated Provider</label>
                    <select
                        class="form-select"
                        id="regular-provider"
                        name="regular-provider"
                        required="required"
                        aria-required="true"
                        v-model="regularDetails.provider_id"
                    >
                        <option v-for="provider in providers" :key="provider.id" :value="provider.id">{{
                                provider.name
                            }}
                        </option>
                    </select>
                    <div id="regular-provider-help" class="form-text">
                        <p>
                            Please select a default service or goods provider for this new regular transaction.<br/>
                            Alternatively, you can select to create a new provider
                        </p>
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
    </bank-modal-base>
</template>

<script>
const bootstrap = require('bootstrap');
import User from '../../../includes/user';

export default {
    name: "bank-modal-add-regular",
    data() {
        return {
            ajaxRegularData: null,
            ajaxUrl: `/regulars/create_from_js`,
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
                    date: null,
                    variable_amount: 0,
                    entry: '',
                    remarks: '',
                    alias: ''
                };
            } else {
                return this.$store.state.newRegularDetails;
            }
        }
    },
    methods: {
        async submit(event) {
            if (0 === this.regularDetails.alias.length) return;

            this.disableSubmitButton();
            const ajaxData = {
                user_id: User.id,
                alias: this.regularDetails.alias,
                payment_method_id: this.regularDetails.payment_method_id,
                remarks: this.regularDetails.remarks,
                amount: this.regularDetails.amount,
                transaction_id: this.regularDetails.transaction_id,
                variable: this.regularDetails.variable_amount,
                provider_id: this.regularDetails.provider_id,
                period_name: this.regularDetails.period_name,
                period_multiplier: this.regularDetails.period_multiplier,
                type: 'json'
            };

            const returnedData = await axios.post(this.ajaxUrl, ajaxData);

            this.resetForm();
            window.addRegularModal.hide();

            if (returnedData.status === 201) {
                const regularId = returnedData.data.regular.id;
                this.regularSuccessfullyAdded({
                    id: regularId,
                    name: returnedData.data.regular.alias,
                });
                this.$store.commit('updateUserDetails', returnedData.data.user);
                this.$store.commit('updateRouteBadges', returnedData.data.user.badges);
                this.$emit('success');
                // this.$store.commit('newRegularDetected', this.regularName);
                Toast.fire({title: "Regular Added", icon: "success"})
            } else {
                console.groupCollapsed('"Submit" action failed')
                console.log('Status: ', returnedData.status);
                console.info('Reply...');
                console.log(returnedData.data);
                console.info('Headers...');
                console.log(returnedData.headers);
                console.groupEnd();
                Toast.fire({title: "Something went wrong!", icon: "error"})
            }
        },
        dismissModal: function () {
            this.resetForm();
            window.addRegularModal.hide();
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
        },
        copyEntryToAlias: function (event) {
            event.stopPropagation();
            event.preventDefault();
            this.$set(this.regularDetails, 'alias', this.regularDetails.entry);
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
<style lang="scss">
*[data-required="true"]::after {
    content: " *";
    color: red;
}
</style>
