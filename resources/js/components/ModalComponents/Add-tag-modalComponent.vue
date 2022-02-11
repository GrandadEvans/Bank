<template>
    <modal id="add-tag-modal">
        <template v-slot:modal-header>
            Add a new tag
        </template>

        <template v-slot:modal-body>
            <form id="add-tag-form" aria-label="This form allows you to select or add a new tag">
                <div class="mb-3" aria-label="This is the tag name section of the form">
                    <label for="tag-name" class="form-label">Tag Name</label>
                    <input
                        aria-describedby="tag-name-help"
                        class="form-control"
                        id="tag-name"
                        list="existing-tags"
                        name="tag-name"
                        placeholder="Type to search..."
                        type="search"
                        v-model="tagName"
                        @keyup="checkTagName"
                        @keyup.enter.prevent="submit"
                    />
                          <datalist id="existing-tags">
                        <option
                            :value="tag.tag"
                            :data-background_color="tag.default_color"
                            :data-icon="tag.icon"
                            :data-id="tag.id"
                            :data-tag="tag.tag"
                            :key="tag.id"
                            v-for="tag in existingTags"
                            @click="submit"
                        />
                    </datalist>
                    <div id="tag-name-help" class="form-text">
                        <p>
                            What do you want to name the tag?<br />
                            Can't see what you want? <span class="fake-link" @click="showAddForm">Add a new one</span><br />
                            If you want to add a new tag, type "<strong>new:</strong>", then the new tag name.
                        </p>
                    </div>
                </div>

                <div class="mb-3" v-if="addFormVisible" aria-label="This section is related to the tags icon">
                    <label for="tag-icon" class="form-text">Icon</label>
                    <input
                        aria-describedby="tag-icon-help"
                        class="form-control"
                        id="tag-icon"
                        placeholder="eg fab fa-mastercard"
                        type="text"
                        v-model="tagIcon"
                    >
                    <div id="tag-icon-help" class="form-text">What icon do you want to associate with the tag?<br />
                        You can browse available icons <a
                            href="https://fontawesome.com/icons?d=gallery&m=free" class="link-info">here</a></div>
                </div>

                <div
                    aria-label="This section allows you to choose a colour for the icons background"
                    class="mb-3"
                    v-if="addFormVisible"
                >
                    <label for="tag-bg-color" class="form-label">Background Colour</label>
                    <input
                        class="form-control"
                        id="tag-bg-color"
                        type="color"
                        v-model="tagBgColor"
                    >
                </div>
            </form>

            <div
                aria-label="This is a read only section that displays the tags icon"
                class="mb-3 tag-example"
                v-if="allFieldsSet"
            >
                <span :style="{
                    'background-color': tagBgColor,
                    'color': contrastedColor
                }">
                <font-awesome-icon :icon="fontAwesomeIcon.icon" :size="fontAwesomeIcon.size"/>
                    </span>
            </div>
        </template>

        <template v-slot:modal-footer>
            <button
                aria-label="Cancel and dismiss the add tag modal"
                class="btn btn-warning"
                data-bs-dismiss="modal"
                type="button"
                @click="dismissModal"
            >Cancel</button>

            <button
                aria-label="Submit the form and associate the chosen tag with the parent item eg transaction"
                class="btn btn-primary"
                form="add-tag-form"
                id="add-tag-submit-button"
                type="button"
                @click="submit"
            >Add tag</button>

            <button
                aria-label="Submit the form and associate the chosen tag with the parent item eg transaction, then search for similar transactions"
                class="btn btn-secondary"
                form="add-tag-form"
                id="add-tag-and-search-submit-button"
                type="button"
                @click="submitAndSearch"
            >Add &amp; look for others</button>
        </template>
    </modal>
</template>

<script>
import {blackOrWhite, randomColour} from '../../helperFunctions';

const bootstrap = require('bootstrap');

export default {
    name: "add-tag-modal",
    data() {
        return {
            addFormVisible: false,
            ajaxTagData: null,
            ajaxUrl: '/tags/store-from-js',
            findSimilar: false,
            tagBgColor: randomColour(),
            tagIcon: 'question',
            tagName: '',
        }
    },
    computed: {
        transactionId: function () {
            return this.$store.state.modalTransactionId
        },
        fontAwesomeIcon () {
            return {
                icon: this.tagIcon,
                size: '3x'
            };
        },
        allFieldsSet () {
            return (null != this.tagBgColor && null != this.tagIcon && null != this.tagName);
        },
        contrastedColor () {
            return blackOrWhite(this.tagBgColor);
        },
        existingTags: function () {
            return this.$store.state.tagList;
        }
    },
    methods: {
        async submit (event) {
            if (0 === this.tagName.length) return;

            this.disableSubmitButton();

            if (this.addFormVisible) {
                this.setNewTagData();
            } else {
                this.getTagDetailsFromDatalistOption();
            }

            const value = event.target.value;

            const ajaxData = {
                default_color: this.ajaxTagData.default_color,
                find_similar: (this.findSimilar) ? 1 : 0,
                tag_icon: this.ajaxTagData.icon,
                tag_id: this.ajaxTagData.tag_id,
                tag_name: this.ajaxTagData.tag,
                transaction_id: this.transactionId
            };

            const returnedData = await axios.post(this.ajaxUrl, ajaxData);
            const data = returnedData.data;

            window.addTagModal.hide();
            if (returnedData.status === 201) {
                const tagId = data.tag_id;
                const similar_transactions = data.similar_transactions;

                this.tagSuccessfullyAdded({
                    bgColor: data.default_color,
                    icon: data.tag_icon,
                    id: tagId,
                    name: data.tag_name,
                    similarTransactions: similar_transactions
                });
                this.showSimilar(similar_transactions, tagId)
            } else {
                console.groupCollapsed('"Submit" action failed')
                console.log('Status: ', returnedData.status);
                console.info('Reply...');
                console.log(data);
                console.info('Headers...');
                console.log(returnedData.headers);
                console.groupEnd();
            }
            this.resetForm();
        },
        async updateTags() {
            if (this.$store.state.tagList.length === 0) {
                const url = '/tags/simple_list';
                const returnedData = await axios.get(url);

                if (returnedData.status === 200) {
                    this.$store.commit('updateTagList', returnedData.data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Could not get the latest tags',
                    });
                }
            }

            // Now we have up to date tags
        },
        checkTagName: function () {
            for(let t=0;t<this.existingTags.length;t++) {
                let tag = this.existingTags[t];
                let value = this.tagName.toLowerCase();
                let currentTag = tag.tag.toLowerCase();

                if (currentTag.includes(value)) {
                    this.addFormVisible = false;
                    return
                }
            }
            this.addFormVisible = true;
        },
        dismissModal: function () {
            this.resetForm();
            window.addTagModal.dispose();
        },
        disableSubmitButton () {
            document.getElementById("add-tag-submit-button").setAttribute("disabled", "disabled");
        },
        enableSubmitButton () {
            document.getElementById("add-tag-submit-button").removeAttribute("disabled")
        },
        getTagDetailsFromDatalistOption: function () {
            const value = document.getElementById("tag-name").value;
            const dataset = document.querySelector("#existing-tags option[value='" + value + "']").dataset;

            this.ajaxTagData = {
                tag_id: parseInt(dataset.id),
                tag: dataset.tag,
                transaction_id: parseInt(this.$store.state.modalTransactionId),
                icon: dataset.icon,
                default_color: dataset.background_color
            }
        },
        resetForm () {
            this.tagBgColor = randomColour()    ;
            this.tagName = null;
            this.tagIcon = null;
            this.$store.commit('updateModalTransactionId', null)
            this.findSimilar = false;
            this.enableSubmitButton();
        },
        setNewTagData: function () {
            this.ajaxTagData = {
                tag: this.tagName.replace('new:', '').trim(),
                icon: this.tagIcon,
                default_color: this.tagBgColor.replace('#', ''),
                transaction_id: parseInt(this.$store.state.modalTransactionId),
            };
        },
        showAddForm () {
            this.addFormVisible = !this.addFormVisible;
        },
        showIcon (tag) {
            this.tagBgColor = tag.background_color;
            this.contrastedColor = tag.contrasted_color;
            this.tagIcon = tag.icon;
            this.tagName = tag.tag;
        },
        showSimilar: function (similar, tagId) {
            if (this.findSimilar === true) {
                if (similar.length > 0) {
                    this.$store.commit('updateSimilarTransactions', similar);
                    this.$store.commit('updateSimilarTransactionsEntityId', tagId);
                    this.$store.commit('updateSimilarTransactionsType', 'tag');
                    window.addSimilarTransactionsModal.show()
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: "There are no similar transactions"
                    });
                }
            }
        },
        submitAndSearch: function (event) {
            this.findSimilar = true;
            this.submit(event);
        },
        tagSuccessfullyAdded: function (tagDetails) {
            this.$store.commit('updateNewEntityDetails', {
                id: tagDetails.id,
                name: tagDetails.name,
                icon: tagDetails.icon,
                bgColor: tagDetails.bgColor,
            });
        },
    },
    mounted () {
        window.addTagModal = new bootstrap.Modal(document.getElementById('add-tag-modal'))
        this.updateTags();
    }
}
</script>

<style lang="scss">
    .tag-example {
        display: flex;

        .fa, .fab, .fal, .far, .fas {
            border-radius: 50%;
            line-height: 3rem;
            text-align: center;
            padding: 0.5rem;
            margin: auto auto;
        }
    }

    .fake-link {
        text-decoration: underline;
        cursor: pointer;
        //color: var(--)
    }
</style>
