<template>
    <span>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ count }}</span>
        <span class="visually-hidden">{{ count }} unread messages</span>
  </span>
</template>

<script>
export default {
    name: "badge-component",
    props: [
        'count'
    ]
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
