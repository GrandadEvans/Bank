<template>
    <div class="row">
        <div class="container">
            <form
                class="mb-6 offset-6"
                v-on:submit.stop.prevent
            >
                <div class="input-group">
                    <span class="input-group-text" id="search-input-icon">@</span>
                    <input
                        aria-label="Search term"
                        aria-describedby="search-help"
                        :class="isValidSearch"
                        id="search-input"
                        type="search"
                        placeholder="What do you want to search for?"
                        v-model="search"
                        @keyup="getResults"
                    >
                </div>
                <div id="search-help" class="form-text">
                    <p>
                        Use this search field to filter the transactions using the transaction text.<br/>
                        <!--                        Top Tip: You can filter by provider by prepending the search term with "@provider" or ":provider"-->
                        Searching will only be applied to {{ minimumValidLength }} of more characters
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "search",
    data: function () {
        return {
            search: '',
            minimumValidLength: 3
        }
    },
    computed: {
        isValidSearch: function () {
            let inputClass = 'form-control';
            let len = this.search.length;

            if (len > 0) {
                if (this.search.length >= this.minimumValidLength) {
                    inputClass += ' is-valid';
                } else {
                    inputClass += ' is-invalid';
                }
            }
            return inputClass;
        }
    },
    methods: {
        getResults() {
            if (!_.inRange(this.search.length, 1, this.minimumValidLength)) {
                this.$emit('search', this.search);
            }
        }
    }
}
</script>
