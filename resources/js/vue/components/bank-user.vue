<template>
    <div>

    </div>
</template>

<script>
// export class user {
//     constructor(details) {
//         this.email = details.email || '';
//         this.badgesDetails = details.badges || {};
//     }
//
//     get badges() {
//         return this.badgesDetails;
//     }
// };
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

            return returnedData.data;
        }
    },
    mounted() {
        // Vue.bankUser = this;
        // let USER = new user(this.getUserDetails());
        // console.log('User class', USER);
        // console.log('User Badges', USER.badges)
    }
}
</script>
