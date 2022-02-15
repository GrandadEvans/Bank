<template>
    <div>
        <slot>
            <select
                name="providers-select"
                id="providers-select"
                class="providers-select"
                v-on:change="chooseProvider"
                v-model="providerSelected"
                :disabled="false"
                role="listbox"
            >
                <option disabled="disabled" aria-disabled="true">Choose a provider</option>
                <option disabled="disabled" aria-disabled="true" v-if="!simple_list">-- choose an existing provider --
                </option>
                <option
                    v-for="provider in providers"
                    :value="provider.id"
                    role="option"
                >{{ provider.name }}
                </option>
                <option disabled="disabled" aria-disabled="true" v-if="!simple_list">-- or provide a new one --</option>
                <option value="add-new" v-if="!simple_list">I'll create a new one</option>
            </select>
    </slot>
    </div>

</template>

<script>
export default {
    name: "provider-select",
    props: [
        'transaction_id',
        'simple_list'
    ],
    data: function () {
        return {
            providerSelected: ''
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
                if (null !== this.$store.state.newEntityDetails) {
                    const newProvider = this.$store.state.newEntityDetails;
                    this.$emit('provider-updated', newProvider);

                    Toast.fire({icon: 'success', title: 'New provider added to transaction'});
                    this.$store.commit('updateNewEntityDetails', null);
                }
            });
        },
        async chooseProvider (event) {
            if (event.target.value === 'add-new') {
                this.showNewProviderModal();
                return;
            }
            this.isDisabled(true);
            let provider_id = this.providerSelected;
            let url = `/transactions/${this.transaction_id}/update_provider/${provider_id}`;

            const returnedData = await axios.get(url);
            this.$emit('provider-updated', returnedData.data[0]);

            Toast.fire({icon: 'success', title: 'Transaction updated'});
        },
        async updateProviders() {
            this.providerContent = '';
            let url = `/providers/simple_list`;
            const returnedData = await axios.get(url);
            this.$store.commit('updateProvidersData', returnedData.data);
        },
    },
    mounted: function () {
        if (this.$store.state.providersLoaded.length === 0) {
            this.updateProviders();
        }
    }
}
</script>
