<template>
    <div>
        <select
            name="providers-select"
            id="providers-select"
            class="providers-select"
            v-model="id"
            role="listbox"
        >
            <option
                v-for="provider in providers"
                :value="provider.id"
                :key="provider.id"
                role="option"
            >{{ provider.name }}
            </option>
        </select>
    </div>
</template>

<script>
// @todo: Move both provider-select components to one with the help of a suit of test
export default {
    name: "provider-select-for-pr",
    props: [
        'id'
    ],
    data: function () {
        return {
            providerSelected: '',
            providers: [],
            providerId: null
        }
    },
    methods: {
        async updateProviders() {
            const url = '/providers/simple_list';
            const returnedData = await axios.get(url);

            if (returnedData.status === 200) {
                this.providers = returnedData.data;
                this.$store.commit('updateProvidersData', returnedData.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Could not get the latest providers'
                });
                console.log('Provider error: ', returnedData.data);
            }
        }
    },
    mounted() {
        let providers = this.$store.state.providersData;
        if (providers.length === 0) {
            this.updateProviders();
        } else {
            this.providers = providers;
        }
    }
}
</script>
