<template>
    <div v-on:dblclick="showProviderSelectBox">
        <slot>
            <provider-select
                :transaction="transaction"
                v-on:provider-updated="providerUpdated"
                v-if="!read_only"
            ></provider-select>
        </slot>
    </div>
</template>

<script>
export default {
    name: "td-provider",
    props: [
        'transaction',
        'read_only'
    ],
    methods: {
        providerUpdated: function (provider) {
            return this.$el.innerHTML = `<div>${provider.name}</div>`;
        },
        async showProviderSelectBox () {
            if (this.$store.state.providersLoaded) {
                this.$emit('db-click');
            } else {
                this.providerContent = '';
                let url = `/providers/simple_list`;
                this.$store.commit('providersLoaded', false);
                const returnedData = await axios.get(url);
                this.$store.commit('updateLatestProvidersData', returnedData.data);
                this.$store.commit('providersLoaded', true);
            }
        }
    },
}
</script>
