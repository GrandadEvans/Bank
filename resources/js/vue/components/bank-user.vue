<template>
    <div>

    </div>
</template>

<script>
export default {
    name: "bank-user",
    data: function () {
        return {
            userDetails: {}
        }
    },
    computed: {
        updateUserDetails: function () {
            if (this.userDetails !== this.$store.state.userDetails) {
                this.userDetails = this.$store.state.userDetails;
            }
        }
    },
    methods: {
        async getUserDetails() {
            let url = '/get-user-details';
            // @todo is the auth done or do I need to do it?
            let returnedData = await axios.get(url);
            this.$store.commit('updateUserDetails', returnedData.data);
            this.$store.commit('updateRouteBadges', returnedData.data.badges);
        }
    },
    mounted() {
        Vue.bankUser = this;
        this.getUserDetails();
    }
}
</script>
