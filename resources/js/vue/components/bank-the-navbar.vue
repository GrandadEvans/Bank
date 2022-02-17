<template>
    <div>
    <nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" :href="route_home">Banking App</a>

        <button
            class="navbar-toggler position-absolute d-md-none collapsed"
            type="button"
            data-toggle="collapse"
            data-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="nav-link" :href="route_home">Home</a>

        <ul class="navbar-nav px-3" v-if="loggedIn">
            <li class="nav-item px-3 dropdown">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdown1"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">

                    {{  greeting }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" :href="route_logout">Logout</a>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav px-3" v-else>
            <li class="nav-item px-3 dropdown">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdown4"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">

                    Login/Register
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" :href="route_login">Login</a>
                    <a class="dropdown-item" :href="route_register">Register</a>
                </div>
            </li>
        </ul>
    </nav>
    </div>

</template>

<script>
export default {
    name: "bank-the-navbar",
    props: [
        'route_home',
        'route_logout',
        'route_login',
        'route_register',
    ],
    data () {
        return {
            user () {
                return this.$store.state.userDetails;
            }
        }
    },
    computed: {
        loggedIn: function () {
            return this.user.loggedIn;
        },
        greeting: function () {
            return `Hi, ${this.user.firstName}`;
        }
    },
    mounted() {
        console.log('navbar')
    }
}
</script>

