<template>
    <ul class="tags_list" :style="{'flex-direction': direction}">
        <li class="tag-edit-li">
            <i
                class="fas fa-plus-circle add-new-tag"
                @click="addNewTag"
                v-on:tag-added="tagAdded"
            ></i>
            <i v-if="validTags" class="fas fa-times-circle exit-edit-mode"
               v-on:click="changeTagMode"></i>
        </li>
        <tag
            v-for="(tag, index) in taglist"
            :icon="tag.icon"
            :text="tag.tag"
            :id="tag.id"
            :tag="tag.tag"
            :background_color="tag.default_color"
            :contrasted_color="tag.contrasted_color"
            :key="tag.id"
            :mode="mode"
            :transaction_id="transaction_id"
            :index="index"
            v-on:tag-deleted="tagDeleted"
            class="tags_list"
        ></tag>
    </ul>
</template>

<script>
const bootstrap = require('bootstrap');
import { blackOrWhite } from '../helperFunctions'

    export default {
        name: "tags-list",
        props: [
            'index',
            'tags',
            'mode',
            'transaction_id',
            'tag_count'
        ],
        computed: {
            direction: function () {
                return (this.mode === 'edit') ? 'column' : 'row';
            },
            validTags: function () {
                return (this.mode === 'edit' && this.tags.length > 0);
            },
            taglist () {
                if (null !== this.$store.state.newTagDetails) {
                    this.tagAdded();
                }
                return this.tags;
            }
        },
        methods: {
            changeTagMode: function () {
                this.$emit('change-tag-mode');
            },
            tagDeleted: function (index) {
                this.$emit('tag-deleted', index);
            },
            addNewTag: function () {
                this.$store.commit('updateModalToShow', 'add-tag-modal')
                this.$store.commit('updateModalTransactionId', this.transaction_id)
                this.$store.commit('updateModalIndex', this.$props.index)
                window.addTagModal.show();
            },
            tagAdded: function () {
                const newItem = {
                    icon: this.$store.state.newTagDetails.icon,
                    tag: this.$store.state.newTagDetails.name,
                    id: this.$store.state.newTagDetails.id,
                    default_color: this.$store.state.newTagDetails.bgColor,
                    contrasted_color: blackOrWhite(this.$store.state.newTagDetails.bgColor)
                };
                let activeIndex = this.$store.state.modalIndex;
                let activeRow = this.$parent.$parent.$refs['transaction-table-tags-list-row'][activeIndex];
                let activeTags = activeRow.$options.propsData.row.tags;
                activeTags.push(newItem);

                this.$store.commit('newTagDetected', null);
                this.$store.commit('updateModalTransactionId', null)
                this.$store.commit('updateModalIndex', null)
            },
        },
    }
</script>

<style lang="scss">
    .tags_list {
        display: flex;
        padding-left: 0;
        margin-bottom: 0;
    }
    .tag-edit-li {
        display: flex;
        justify-content: space-evenly;
        text-align: center;
        //font-size: 1.5rem;
        //margin-bottom: 0.5rem;

        .add-new-tag {
            color: darkgreen;
            cursor: pointer;
        }
        .exit-edit-mode {
            color: darkred;
            cursor: pointer;
        }
    }
</style>
