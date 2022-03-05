<template>
    <nav class="nav navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
        <a class="nav-link navbar-brand col-md-3 col-lg-2 mr-0 px-3" :href="route_home">Banking App</a>

        <a
             class="navbar-toggler position-absolute d-md-none collapsed"
             type="button"
             data-bs-toggle="collapse"
             data-target="#sidebarMenu"
             aria-controls="sidebarMenu"
             aria-expanded="false"
             aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

           </a>

        <a class="nav-link" :href="route_home">Home</a>

        <ul class="navbar-nav px-3" v-if="loggedIn">
            <li class="nav-item px-3 dropdown">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdownAuth"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">

                    Hi, {{ name }} - see your Account
                </a>
                <div class="dropdown-menu navbar-dark" aria-labelledby="navbarDropdownAuth" style="position: absolute;">
                    <a class="dropdown-item" :href="route_logout">Logout</a>
                </div>
            </li>
        </ul>

        <li class="nav-item dropdown" v-else>
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdownGuest"
                role="button"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">

                Login/Register</a>

            <ul class="dropdown-menu">
                <li><a class="dropdown-item register-link" :href="route_register">Register</a></li>
                <li><a class="dropdown-item login-link" :href="route_login">Login</a></li>
            </ul>
        </li>

        <div>&nbsp;</div>
    </nav>
</template>

<script>
import * as bootstrap from "bootstrap";

export default {
    name: "bank-the-navbar",
    props: [
        'route_home',
        'route_logout',
        'route_login',
        'route_register',
    ],
    computed: {
        loggedIn: function () {
            return (this.$store.state.user.loggedIn === true);
        },
        name: function () {
            return this.$store.state.user.name;
        }
    },
    mounted() {
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl, {
                popperConfig: function (defaultBsPopperConfig) {
                    let newConfig = {
                        strategy: 'absolute'
                    };
                    return newConfig;
                }
            })
        })

    }
}
</script>

<style>
.dropdown-menu {
    position: absolute;
    color: var(--bs-body-color);
}
</style>
