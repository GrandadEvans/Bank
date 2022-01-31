<template>
    <div
        aria-live="polite"
        aria-label="Live badge count"
        class="badge">
        <a href="this.href">
            <slot></slot>
        </a>
    </div>
</template>

<script>
export default {
    name: "badge-component",
}
</script>

<style lang="scss">
.badge {
    border-radius: 10rem;
    background-color: darkred;
    color: lightgrey;
    font-size: 1.5rem;
    padding: 0.25rem;
    text-align: center;
    vertical-align: middle;
}
</style>
