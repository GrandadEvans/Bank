<template>
    <div :class="posNegClasses">
        {{ formattedAmount }}
    </div>
</template>

<script>
import { currency } from '../helperFunctions'
export default {
    name: "td-amount",
    props: [
        'currency',
        'amount',
        'symbol',
        'prepend',
        'post',
        'formatted',
    ],
    computed: {
        posNegClasses: function () {
            if (this.amount < 0) {
                return "currency-amount currency-negative";
            } else {
                return "currency-amount currency-positive";
            }
        },
        formattedAmount: function () {
            return currency(this.amount);
        }
    }
}
</script>

<style lang="scss">
    .currency-amount {
        text-align: right;
        padding-right: 1rem;
        letter-spacing: 0.1em;
        min-width: 7.5rem;
    }

    .currency-negative {
            color: red;
        }

    .currency-positive {
            color: green;
        }
</style>
