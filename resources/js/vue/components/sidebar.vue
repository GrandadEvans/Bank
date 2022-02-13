<template>
    <nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="/home">
                        <font-awesome-icon icon="fa-solid fa-home"/>
                        Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" :href="transactions__index">
                        <font-awesome-icon icon="fa-solid fa-calendar-days"/>&nbsp;Transactions</a>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" :href="transactions__create">
                                <font-awesome-icon icon="fa-solid fa-calendar-days"/>&nbsp;Add Transaction</a>
                        </li>
                    </ul>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" :href="transactions__import">
                                <font-awesome-icon
                                    icon="fa-solid fa-calendar-days"/>&nbsp;Import Transaction</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" :href="providers__create">
                        <font-awesome-icon icon="fa-solid fa-shop"
                        />
                        Providers</a>
                    <ul>
                        <li class="nav-item">
                            <!-- 2 different links due to Codeception not recognising link with icon and space in -->
                            <a class="nav-link" :href="providers__create">
                                <font-awesome-icon icon="fa-solid fa-shop"
                                />&nbsp;Add Provider</a>
                        </li>
                        <li class="nav-item">
                            <!-- 2 different links due to Codeception not recognising link with icon and space in -->
                            <a class="nav-link" :href="providers__index">
                                <font-awesome-icon icon="fa-solid fa-shop"
                                />&nbsp;List Provider</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" :href="tags__index">
                        <font-awesome-icon icon="fa-solid fa-tags"/>&nbsp;Tags</a>
                    <ul>
                        <li class="nav-item">
                            <!-- 2 different links due to Codeception not recognising link with icon and space in -->
                            <a class="nav-link" :href="tags__create">
                                <font-awesome-icon icon="fa-solid fa-tags"/>&nbsp;Add Tag</a>
                        </li>
                        <li class="nav-item">
                            <!-- 2 different links due to Codeception not recognising link with icon and space in -->
                            <a class="nav-link" :href="tags__index">
                                <font-awesome-icon icon="fa-solid fa-tags"/>&nbsp;List Tags</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" :href="regulars__index">
                        <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                        Regulars</a>
                    <ul>
                        <!-- TODO: Change icon -->
                        <li class="nav-item">
                            <a class="nav-link" :href="possible_regulars__scan" @click.stop.prevent="scanForNewRegulars"
                            >
                                <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                                Scan for new Regulars</a>
                        </li>
                        <li class="nav-item" @click="resetNewRegularsCounter">
                            <a class="nav-link" :href="possible_regulars__scan_results">
                                <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                                <span style="position: relative">View latest scan results<badge
                                    :count="regularsBadgeCount" v-if="regularsBadgeCount > 0"></badge></span>
                            </a>
                        </li>
                    </ul>
                    <ul>
                    </ul>
                </li>
            </ul>

            <div id="sidebar_piechart">
                <div id="chart_div"></div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "sidebar",
    props: [
        'transactions__import',
        'transactions__index',
        'transactions__create',
        'providers__index',
        'providers__create',
        'tags__index',
        'tags__create',
        'regulars__index',
        'possible_regulars__scan',
        'possible_regulars__scan_results'
    ],
    data() {
        return {
            /* @todo: Persist to the session, not just the page */
            regularsBadgeCount: 0
        }
    },
    computed: {},
    methods: {
        async scanForNewRegulars() {
            let returnedData = await axios.get('/possible-regulars/scan'),
                type = '',
                title = '',
                text = '';

            if (returnedData.status === 202) {
                type = 'success';
                title = 'Success';
                text = 'A new scan is underway, and you\'ll be informed of the results in a few minutes';
            } else {
                type = 'error';
                title = 'Error!';
                text = 'There was an unknown error whilst requesting your latest regular transaction scan.<br />Please contact me if this has ruined your life';
            }


            Swal.fire({
                'type': type,
                'title': title,
                'text': text,
            });
        },
        increaseCount() {
            return this.regularsBadgeCount++;
        },
        resetNewRegularsCounter() {
            return this.regularsBadgeCount = 0;
        }
    }
}
</script>

<style lang="scss">

</style>
