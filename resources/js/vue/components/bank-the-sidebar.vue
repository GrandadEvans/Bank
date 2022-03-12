<template>
    <nav class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse" data-cy="sidebar">
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="/home" data-cy="sidebar-link_dashboard">
                        <font-awesome-icon icon="fa-solid fa-home"/>
                        <span style="position: relative">Dashboard<bank-base-badge route="home"/></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" :href="transactions__index">
                        <font-awesome-icon icon="fa-solid fa-calendar-days"/>
                        <span style="position: relative">Transactions<bank-base-badge
                            route="transactions__index"/></span>
                    </a>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" :href="transactions__create"  data-cy="sidebar-link_transaction-add">
                                <font-awesome-icon icon="fa-solid fa-calendar-days"/>&nbsp;Add Transaction
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" :href="transactions__import">
                                <font-awesome-icon icon="fa-solid fa-calendar-days"/>&nbsp;Import Transaction
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" :href="providers__index">
                        <font-awesome-icon icon="fa-solid fa-shop"/>
                        <span style="position: relative">Providers<bank-base-badge route="providers__index"/></span>
                    </a>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" :href="providers__create">
                                <font-awesome-icon icon="fa-solid fa-shop"/>&nbsp;Add Provider
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :href="providers__index">
                                <font-awesome-icon icon="fa-solid fa-shop"/>&nbsp;List Provider
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" :href="tags__index">
                        <font-awesome-icon icon="fa-solid fa-tags"/>
                        <span style="position: relative">Tags<bank-base-badge route="tags__index"/></span>
                    </a>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" :href="tags__create">
                                <font-awesome-icon icon="fa-solid fa-tags"/>&nbsp;Add Tag
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :href="tags__index">
                                <font-awesome-icon icon="fa-solid fa-tags"/>&nbsp;List Tags
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" :href="regulars__index">
                        <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                        <span style="position: relative">Regulars Payments
                        <bank-base-badge route="regulars__index"/>
                        </span>
                    </a>
                    <ul>
                        <!-- TODO: Change icon -->
                        <li class="nav-item">
                            <a class="nav-link" :href="possible_regulars__scan"
                               @click.prevent.stop="scanForNewRegulars">
                                <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                                Scan for new Regulars
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :href="possible_regulars__scan_results">
                                <font-awesome-icon icon="fa-solid fa-arrow-rotate-left"/>
                                <span style="position: relative">Outstanding scan results
                                <bank-base-badge route="possible_regulars__scan_results"/>
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

<!--            <div id="sidebar_piechart">-->
<!--                <div id="chart_div"></div>-->
<!--            </div>-->
        </div>
    </nav>
</template>

<script>
export default {
    name: "bank-the-sidebar",
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
    }
}
</script>
