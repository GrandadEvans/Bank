<template>
    <nav>
        <ul>
            <li v-if="loggedIn">
        </ul>
    </nav>
</template>

<script>
export default {
    name: "sidebar",
    methods: {
        loggedIn: () => {
            if (document.getElementById("log-in-id")) {
                return true;
            } else {
                return false;
            }
        }
    }
}
</script>

<style lang="scss">

</style>
