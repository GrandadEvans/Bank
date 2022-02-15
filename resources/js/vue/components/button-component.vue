<template>
    <div class="row">
        <div class="container">
            <button
                aria-label="label"
                class="button form-control"
                form="form-id"
                id="id"
                type="button"
                @click="buttonClicked"
            >{{ text }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "button-component",
    data: function () {
        return {}
    },
    props: [
        'label',
        'form-id',
        'id',
        'text'
    ],
    computed: {},
    methods: {
        buttonClicked() {
        }
    }
}
</script>

<style lang="scss"></style>
