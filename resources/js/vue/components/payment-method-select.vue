<template>
    <div>
        <select
            name="payment-method-select"
            id="payment-method-select"
            class="payment-method-select"
            role="listbox"
            v-model="id"
        >
            <option
                v-for="method in paymentMethods"
                :key="method.id"
                :value="method.id"
                role="option"
            >{{ method.method }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: "payment-method-select",
    props: [
        'id'
    ],
    data: function () {
        return {
            paymentMethodSelected: '',
            paymentMethods: null,
            paymentMethodId: null
        }
    },
    methods: {
        async updateMethods() {
            const url = '/payment_methods/all';
            const returnedData = await axios.get(url);

            if (returnedData.status === 200) {
                this.paymentMethods = returnedData.data;
                this.$store.commit('updatePaymentMethods', returnedData.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Could not get the latest payment methods'
                });
                console.log('Payment Method error: ', returnedData.data);
            }
        }
    },
    mounted() {
        let paymentMethods = this.$store.state.paymentMethods;
        if (paymentMethods.length === 0) {
            this.updateMethods();
        } else {
            this.paymentMethods = paymentMethods;
        }
    }
}
</script>
