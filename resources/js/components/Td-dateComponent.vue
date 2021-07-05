<template>
    <div class="column-date">
        {{ formattedDate }}
    </div>
</template>

<script>
export default {
    name: "td-date",
    props: ['date',],
    computed: {
        formattedDate: function () {
            return window.moment(this.date).format('Do MMM YYYY');
        }
    }
}
</script>

<style lang="scss">
    .column-date {
        min-width: 7rem;
    }
</style>
