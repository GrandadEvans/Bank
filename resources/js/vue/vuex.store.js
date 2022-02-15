export const storeConfig = {
    state: {
        latestTransactionTableData: {},
        latestTransactionTableStats: {},
        latestRegularTableData: {},
        latestRegularTableStats: {},
        modalIndex: null,
        modalToShow: null,
        modalTransactionId: null,
        newEntityDetails: null,
        newRegularDetails: null,
        newRegularDetailsLoaded: false,
        paymentMethods: [],
        possibleNewRegularsLoaded: false,
        providersData: [],
        providersLoaded: false,
        routeBadges: {},
        similarTransactions: [],
        similarTransactionsEntityId: [],
        similarTransactionsType: null,
        similarTransactionsRowRef: null,
        tagList: [],
        transactionsLoaded: false,
        regularsLoaded: false,
        transactionTable: [
            {
                id: 'transaction_id',
                name: 'transaction_id',
                label: 'ID',
                columnPath: 'transaction_id'
            },
            {
                id: 'transaction_select',
                name: 'transaction_select',
                label: 'Select',
                columnPath: ''
            },
            {
                id: 'transaction_date',
                name: 'transaction_date',
                label: 'Date',
                columnPath: 'transaction.date'
            },
            {
                id: 'transaction_provider',
                name: 'transaction_provider',
                label: 'Provider',
                columnPath: 'provider.name'
            },
            {
                id: 'transaction_description',
                name: 'transaction_description',
                label: 'Description',
                columnPath: 'transaction.description'
            },
            {
                id: 'transaction_amount',
                name: 'transaction_amount',
                label: 'Amount',
                columnPath: 'transaction.amount'
            },
            {
                id: 'transaction_balance',
                name: 'transaction_balance',
                label: 'Balance',
                columnPath: 'transaction.balance'
            },
            {
                id: 'transaction_type',
                name: 'transaction_type',
                label: 'Type',
                columnPath: 'payment_method.name'
            },
            {
                id: 'transaction_tags',
                name: 'transaction_tags',
                label: 'Tags',
                columnPath: 'tags'
            },
            {
                id: 'transaction_remarks',
                name: 'transaction_remarks',
                label: 'Remarks',
                columnPath: 'transaction.remarks'
            },
            {
                id: 'transactions_actions',
                name: 'transactions_actions',
                label: 'Edit',
                columnPath: ''
            }

        ],
        regularTable: [
            // {
            //     id: 'transaction_id',
            //     name: 'transaction_id',
            //     label: 'ID',
            //     columnPath: 'transaction_id'
            // },
            {
                id: 'transaction_date',
                name: 'transaction_date',
                label: 'Date',
                columnPath: 'transaction.date'
            },
            {
                id: 'transaction_provider',
                name: 'transaction_provider',
                label: 'Provider',
                columnPath: 'provider.name'
            },
            // {
            //     id: 'transaction_description',
            //     name: 'transaction_description',
            //     label: 'Description',
            //     columnPath: 'transaction.description'
            // },
            {
                id: 'transaction_amount',
                name: 'transaction_amount',
                label: 'Amount',
                columnPath: 'transaction.amount'
            },
            {
                id: 'transaction_type',
                name: 'transaction_type',
                label: 'Type',
                columnPath: 'payment_method.name'
            },
            {
                id: 'transaction_remarks',
                name: 'transaction_remarks',
                label: 'Remarks',
                columnPath: 'transaction.remarks'
            },
            {
                id: 'transactions_actions',
                name: 'transactions_actions',
                label: 'Edit',
                columnPath: ''
            }
        ]
    },
    mutations: {
        updateLatestTransactionTableData(state, data) {
            state.latestTransactionTableData = data;
        },
        updateLatestTransactionTableStats(state, data) {
            state.latestTransactionTableStats = data;
        },
        updateLatestRegularTableData(state, data) {
            state.latestRegularTableData = data;
        },
        updateLatestRegularTableStats(state, data) {
            state.latestRegularTableStats = data;
        },
        updateModalIndex(state, index) {
            state.modalIndex = index;
        },
        updateModalToShow(state, modal) {
            state.modalToShow = modal;
        },
        updateModalTransactionId(state, id) {
            state.modalTransactionId = id;
        },
        updateNewEntityDetails(state, details) {
            state.newEntityDetails = details;
        },
        updateNewRegularDetails(state, details) {
            state.newRegularDetails = details;
        },
        updateNewRegularDetailsLoaded(state, details) {
            state.newRegularDetailsLoaded = details;
        },
        updatePaymentMethods(state, methods) {
            state.paymentMethods = methods;
        },
        updateProvidersData(state, providers) {
            state.providersData = providers;
        },
        updateProvidersLoaded(state, boolState) {
            state.providersLoaded = boolState;
        },
        updateRouteBadges(state, details) {
            state.routeBadges = details;
        },
        updateSimilarTransactions(state, transactions) {
            state.similarTransactions = transactions;
        },
        updateSimilarTransactionsType(state, type) {
            state.similarTransactionsType = type;
        },
        updateSimilarTransactionsRowRef(state, ref) {
            state.similarTransactionsRowRef = ref;
        },
        updateSimilarTransactionsEntityId(state, id) {
            state.similarTransactionsEntityId = id;
        },
        updateTagList(state, tags) {
            state.tagList = tags;
        },
        updateTransactionRow(state, details) {
            state.latestTransactionTableData[details.index].remarks = details.remark;
        },
        regularsLoaded(state, loadedState) {
            state.regularsLoaded = loadedState;
        },
        transactionsLoaded(state, loadedState) {
            state.transactionsLoaded = loadedState;
        },
        possibleNewRegularsLoaded(state, loadedState) {
            state.possibleNewRegularsLoaded = loadedState;
        }
    }
};
