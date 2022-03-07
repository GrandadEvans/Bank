<template>
    <ul class="tags_list" :style="{'flex-direction': direction}">
        <li class="tag-edit-li">
            <span class="add-new-tag" @click="addNewTag" v-on:tag-added="tagAdded" v-if="!read_only">
            <font-awesome-icon icon="fa-solid fa-circle-plus"/>
            </span>

            <span v-if="validTags" class="exit-edit-mode" v-on:click="changeTagMode">
            <font-awesome-icon icon="fa-solid fa-circle-xmark"/>
            </span>
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
import {blackOrWhite} from '../../includes/helpers'

export default {
    name: "tags-list",
    props: [
        'index',
        'tags',
        'mode',
        'transaction_id',
        'tag_count',
        'read_only'
    ],
    computed: {
            direction: function () {
                return (this.mode === 'edit') ? 'column' : 'row';
            },
            validTags: function () {
                return (this.mode === 'edit' && this.tags.length > 0);
            },
            taglist () {
                if (null !== this.$store.state.newEntityDetails && this.$store.state.similarTransactionsType === 'tag') {
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
                    icon: this.$store.state.newEntityDetails.icon,
                    tag: this.$store.state.newEntityDetails.name,
                    id: this.$store.state.newEntityDetails.id,
                    default_color: this.$store.state.newEntityDetails.bgColor,
                    contrasted_color: blackOrWhite(this.$store.state.newEntityDetails.bgColor)
                };
                let activeIndex = this.$store.state.modalIndex;
                let activeRow = this.$parent.$parent.$refs['transaction-table-entitys-list-row'][activeIndex];
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
