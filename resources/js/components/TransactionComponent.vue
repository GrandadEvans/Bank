<template>
    <tr v-bind:class="{ income: transaction.amount > 0, expenditure: transaction.amount <= 0 }">
        <th>{{ transaction.id }}</th>

<!--        TODO: Filter by date (link needed)-->
        <td :title="getTitleTagForDate(transaction.date)">{{ getFormattedDate(transaction.date) }}</td>

<!--        TODO: Filter by entry (link needed)-->
        <td>
            <span class="entry-details">{{transaction.entry}}</span>
            <span class="entry-icon"><i :class="getEntryIcon(transaction.entry)"></i></span></td>

        <td class="amount">{{ formattedAmount(transaction.amount) }}</td>
        <td :class="getOverdraftStatus(transaction.balance, this.overdraftLimit)">{{ formattedAmount(transaction.balance) }}</td>

<!--        TODO: Filter by remark (link needed)-->
        <td>{{transaction.remarks}}</td>
        <td>Edit</td>
    </tr>
</template>

<script>
import { currency, formatDate } from "../helperFunctions";

export default {
    methods: {
        formattedAmount: amount => currency(amount),
        getOverdraftStatus: (balance, overdraftLimit) => {
            let od = '';
            balance = parseFloat(balance);
            overdraftLimit = parseFloat(overdraftLimit);

            if (balance > 0) {
                od = 'overdraft-good';
            } else if (balance < 0 && balance > overdraftLimit) {
                od = 'overdraft-ok';
            } else if(balance < overdraftLimit) {
                od = 'overdraft-bad';
            } else {
                od = 'overdraft-unknown';
            }
            return od;
        },
        getFormattedDate: date => formatDate(date),
        getTitleTagForDate: (date) => {
            return moment(date).fromNow();
        },
        getEntryIcon: (entry) => {
            /**
             * TODO: I will need to extract this icon functionality to a dedicated icon Class
             * That way - when I add a new regex for a new company for example
             * I won't mess up the rest of the code
             * Each company can have it's own implementation of the class
             */
            let icon = "fab fa-fw fa-";

            if (entry.toLowerCase().indexOf("paypal") !== -1) {
                icon = icon + "paypal";
            }

            return icon;
        }
    }
}
</script>

<style lang="scss">
    .income {
        th {background-color: lightgreen;}
        .amount {color: darkgreen;}
    }

    .expenditure {
        th {background-color: lightcoral;}
        .amount {color: darkred;}
    }

    .amount { text-align: right; }

    .entry-details { float: left; }

    .entry-icon {
        float: right;
        margin-left: 1em;
    }

    .overdraft-good {
        color: green;
        text-shadow: 0px 1px 1px #333;
        text-align: right;
    }

    .overdraft-ok {
        color: red;
        text-shadow: 0px 1px 1px #333;
        text-align: right;
    }

    .overdraft-bad {
        background-color: lightcoral;
        color: antiquewhite;
        font-weight: bold;
        text-shadow: 2px 2px 2px #333;
        text-align: right;
    }
</style>
