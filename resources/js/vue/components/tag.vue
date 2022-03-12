<template>
    <li class="tag-list-li" :style="{'justify-content': justifyTags}">
        <div class="justify-start">
            <div class="icon-round" :style="{ 'background-color': background_color, 'color': contrasted_color, }">
                <font-awesome-icon
                    v-if="null != icon"
                    v-bind:title="tagTitle"
                    v-bind:icon="icon"
                    v-bind:data-cy="icon"/>
                <font-awesome-icon v-else icon="fa-solid fa-circle"/>
            </div>
            <div class="tag-title" v-if="mode === 'edit'">{{ tagTitle }}</div>
        </div>
        <div class="justify-end" v-if="mode === 'edit'">
            <div class="tag-edit">
                <font-awesome-icon icon="fa-solid fa-pen-to-square"/>
            </div>
            <div class="tag-delete" v-on:click="deleteTag">
                <font-awesome-icon icon="fa-solid fa-trash-can"/>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    name: "tag",
    props: {
        'icon': String,
        'tag': String,
        'id': Number,
        'background_color': String,
        'contrasted_color': String,
        'mode': String,
        'transaction_id': Number,
        'index': Number
    },
    computed: {
        tagTitle: function () {
            return this.tag;
        },
        justifyTags: function () {
            return (this.mode === 'edit') ? 'space-between' : 'flex-start';
        },
        iconId: function () {
            return 'icon-'+this.id;
        }
    },
    methods: {
        async deleteTag () {
            let url = `/transactions/${this.transaction_id}/unlink_tag/${this.id}`;
            const returnedData = await axios.delete(url);

            if (returnedData.data === 'OK') {
                this.$emit('tag-deleted', this.index);
                Toast.fire({icon: 'success', title: 'Tag successfully unlinked' });
            } else {
                this.$swal.fire({
                    showConfirmButton: true,
                    icon: 'error',
                    title: `There was an error,
                        ERROR: ${returnedData.data}
                        CODE: ${returnedData.status}`
                });
            }
        }
    }
}
</script>

<style lang="scss">


    .tag-list-li {
        display: flex;
        list-style: none;
        flex-direction: row;
        align-content: center;

        .justify-start { justify-content: flex-start; display:flex; }
        .justify-end { justify-content: flex-end; display: flex }

        .tag-edit,
        .tag-delete,
        .icon-round {
            $border-color: #333;

            border: 1px solid $border-color;
            border-radius: 50%;
            box-shadow: 1px 1px 1px 1px $border-color;
            text-align: center;
            width:       var(--icon-round__circle-size);
            line-height: var(--icon-round__line-height);
            padding:     var(--icon-round__padding);
            margin:      var(--icon-round__margin);
            font-size:   var(--icon-round__font-size);
        }

        .tag-edit,
        .tag-trash {
            cursor: pointer;
        }
        .tag-edit { color: darkblue; }
        .tag-trash { color: darkred; }
    }
</style>
