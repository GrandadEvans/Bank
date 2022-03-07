<template>
    <nav class="nav navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
        <a class="nav-link navbar-brand col-md-3 col-lg-2 mr-0 px-3" v-bind:href="route_home">
            Banking App
        </a>

        <a class="navbar-toggler position-absolute d-md-none collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-target="#sidebarMenu"
                data-cy="navbar-toggle"
                aria-controls="sidebarMenu"
                id="navbarDropdownGuest"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </a>

        <a class="nav-link" v-bind:href="route_home" data-cy="home-link">
            Home
        </a>

        <ul class="navbar-nav px-3" v-if="loggedIn">
            <li class="nav-item px-3 dropdown">
                <a class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        data-cy="navbarDropdownAuth"
                        aria-haspopup="true"
                        aria-expanded="false">
                    Hi, {{ name }} - see your Account
                </a>
                <div class="dropdown-menu navbar-dark" aria-labelledby="navbarDropdownAuth" style="position: absolute;">
                    <a class="dropdown-item" v-bind:href="route_logout" data-cy="logout-link">
                        Logout
                    </a>
                </div>
            </li>
        </ul>

        <li class="nav-item dropdown" v-else>
            <a class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdownGuest"
                    role="button"
                    data-bs-toggle="dropdown"
                    data-cy="navbarDropdownGuest"
                    aria-haspopup="true"
                    aria-expanded="false">
                Login/Register
            </a>

            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" v-bind:href="route_register" data-cy="registration-link">
                        Register
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" v-bind:href="route_login" data-cy="login-link">
                        Login
                    </a>
                </li>
            </ul>
        </li>
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
nav {
    padding-right: 1rem;
}
</style>
