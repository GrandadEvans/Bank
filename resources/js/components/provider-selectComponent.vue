<template>
    <div>
        <slot>
            <select
                name="providers-select"
                id="providers-select"
                class="providers-select"
                v-on:change="chooseProvider"
                v-model="selected"
                :disabled="false"
                role="listbox"
            >
                <option disabled="disabled" aria-disabled="true">Choose a provider</option>
                <option disabled="disabled" aria-disabled="true">-- choose an existing provider --</option>
                <option
                    v-for="provider in providers"
                    :value="provider.id"
                    role="option"
                    >{{ provider.name }}</option>
                <option disabled="disabled" aria-disabled="true">-- or provide a new one --</option>
                <option value="add-new">I'll create a new one</option>
            </select>
    </slot>
    </div>

</template>

<script>
export default {
    name: "provider-select",
    props: [
        'transaction_id'
    ],
    data: function () {
        return {
            selected: ''
        }
    },
    computed: {
        providers: function () {
            if (false === this.$store.state.providersLoaded) {
                this.updateProviders();
                this.$store.commit('updateProvidersLoaded', true);
            }
            return this.$store.state.providersData;
        },
    },
    methods: {
        isDisabled: function (state = false) {
            return state;
        },
        showNewProviderModal: function() {
            this.$store.commit('updateModalTransactionId', this.transaction_id);
            window.addProviderModal.show();
            const providerModalEl = document.getElementById('add-provider-modal');
            providerModalEl.addEventListener('hidden.bs.modal', (event) => {
                if (null !== this.$store.state.newProviderDetails) {
                    const newProvider = this.$store.state.newProviderDetails;
                    this.$emit('provider-updated', newProvider);

                    Toast.fire({icon: 'success', title: 'New provider added to transaction'});
                    this.$store.commit('newProviderDetected', null);
                }
            });
        },
        async chooseProvider (event) {
            if (event.target.value === 'add-new') {
                this.showNewProviderModal();
                return;
            }
            this.isDisabled(true);
            let provider_id = this.selected,
                transaction_id,
                url = `/transactions/${this.transaction_id}/update_provider/${provider_id}`;

            const returnedData = await axios.get(url);
            this.$emit('provider-updated', returnedData.data);

            Toast.fire({ icon: 'success', title: 'Transaction updated' });
        },
        async updateProviders() {
            this.providerContent = '';
            let url = `/providers/simple_list`;
            const returnedData = await axios.get(url);
            this.$store.commit('updateProvidersData', returnedData.data);
        },
    },
}
</script>
