<template>
    <div>
        <abbr :title="formattedPaymentMethod">{{ abbreviation }}</abbr>
    </div>
</template>

<script>

export default {
    name: "td-payment-method",
    props: ['method'],
    computed: {
        formattedPaymentMethod: function () {
            if ("undefined" !== typeof this.method) {
                return this.method.method;
            } else {
                return "N/A";
            }
        },
        abbreviation () {
            let ret = '';
            switch (this.method.method) {
                case 'Deposit':
                case 'Bank Giro Credit':
                    ret = 'DEP';
                    break;
                case 'Debit Card':
                    ret = 'DEB';
                    break;
                case 'Direct Debit':
                    ret = 'DD';
                    break;
                case 'Fast Payment Out':
                case 'Fast Payment In':
                    ret = 'FP';
                    break;
                case 'Standing Order':
                    ret = 'SO';
                    break;
                case 'Cashpoint':
                    ret = 'CPT';
                    break;
                case 'Transfer':
                    ret = 'TFR';
                    break;
                case 'Payment':
                    ret = 'PAY';
                    break;
                case 'Exchange Fee':
                case 'Bank Charge':
                    ret = 'FEE';
                    break;
                case 'Cheque':
                    ret = 'CHK';
                    break;
                case 'Benefit Payment':
                    ret = 'BEN';
                    break;
                default:
                    ret = this.method.method;

            }
            return ret;
        }
    },
}
</script>

<style lang="scss">
</style>
