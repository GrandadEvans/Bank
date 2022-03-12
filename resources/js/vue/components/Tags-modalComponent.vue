<template>
    <div id="modal-tags" v-if="modalContent == 'tags'">
        <p>Modal Tags:</p>
        <ul id="current_tags" class="current_tags">
            <tag
                v-for="tags in modalTags"
                :icon="tags.icon"
                :id="tags.id"
                :tag="tags.tag"
                :background_color="tags.default_color"
                :contrasted_color="tags.contrasted_color"
                :key="tags.id"
            ></tag>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            'transaction_id': Number
        },
        computed: {
            modalTags: function () {
                return this.$store.state.modalTags;
            },
            modalContent: function () {
                return this.$store.state.modalContent;
            }
        }
    }
</script>

<style lang="scss">
    .current_tags {
        display: flex;
        padding-left: inherit;
    }
</style>
