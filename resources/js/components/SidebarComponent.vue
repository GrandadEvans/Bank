<template>
    <nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="/home">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Dashboard <span class="sr-only">(current)</span>
                    </a>
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
                        Providers;</a>
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
                        <li class="nav-item">
                            <a class="nav-link" :href="possible_regulars__scan_results">
                                <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                                <span style="position: relative">View latest scan results<badge-component
                                    :count="regularsBadgeCount" v-if="regularsBadgeCount > 0"></badge-component></span>
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
            regularsBadgeCount: 0
        }
    },
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
        }
    }
}
</script>

<style lang="scss">

</style>
