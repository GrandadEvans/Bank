<template>
    <span v-if="count > 0">
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{
                count
            }}</span>
        <span class="visually-hidden">{{ count }} unread messages</span>
    </span>
</template>

<script>
// import {store} from '../vueComponents'

export default {
    name: "badge",
    props: [
        'route'
    ],
    computed: {
        allBadges: function () {
            let x = this.$store.state.routeBadges;
            // console.log(['x', x]);
            return x;
        },
        count() {
            // console.group('Count')
            let allBadges = this.allBadges;
            // console.log(allBadges);
            let r = this.route;
            // console.log(r);

            let count = allBadges[r] || 0;
            // console.log(count);
            // console.groupEnd()
            if (!allBadges[r]) {
                this.resetCount(r)
            }
            return count;
        },
    },
    methods: {
        resetCount: function (r) {
            // console.log(`Resetting ${r} to 0`);
            return this.updateCount(r, 0);
        },
        updateCount: function (r, count) {
            // console.log(`Setting route (${r}) to (${count})`)
            let badges = this.allBadges;
            badges[r] = count;
            return this.$store.commit('updateRouteBadges', badges);
        }
    }
}
</script>

<style lang="scss">
//.badge {
//    border-radius: 10rem;
//    background-color: darkred;
//    color: lightgrey;
//    font-size: 1.5rem;
//    padding: 0.25rem;
//    text-align: center;
//    vertical-align: middle;
//}
</style>
