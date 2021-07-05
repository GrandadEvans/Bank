export const storeConfig = {
    state: {
        latestTransactionTableData: {},
        latestTransactionTableStats: {},
        modalIndex: null,
        modalToShow: null,
        modalTransactionId: null,
        newTagDetails: null,
        newProviderDetails: null,
        paymentMethods: [],
        providersData: [],
        providersLoaded: false,
        similarTransactions: [],
        similarTransactionsTagId: [],
        tagList: [],
        transactionsLoaded: false,
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
    },
    mutations: {
        newTagDetected(state, details) {
            state.newTagDetails = details;
        },
        newProviderDetected(state, details) {
            state.newProviderDetails = details;
        },
        updateLatestTransactionTableData (state, data) {
            state.latestTransactionTableData = data;
        },
        updateLatestTransactionTableStats (state, data) {
            state.latestTransactionTableStats = data;
        },
        updateModalIndex(state, index) {
            state.modalIndex = index;
        },
        updateModalToShow(state, modal) {
            state.modalToShow = modal;
        },
        updateModalTransactionId(state, id) {
            state.modalTransactionId = id
        },
        updatePaymentMethods(state, methods) {
            state.paymentMethods = methods;
        },
        updateProvidersData(state, providers) {
            state.providersData = providers;
        },
        updateProvidersLoaded (state, boolState) {
            state.providersLoaded = boolState;
        },
        updateSimilarTransactions(state, transactions) {
            state.similarTransactions = transactions;
        },
        updateSimilarTransactionsTagId(state, id) {
            state.similarTransactionsTagId = id;
        },
        updateTagList(state, tags) {
            state.tagList = tags;
        },
        updateTransactionRow(state, details) {
            const index = details.index;
            const remark = details.remark;

            state.latestTransactionTableData[index].remarks = remark;
        },
        transactionsLoaded (state, loadedState) {
            state.transactionsLoaded = loadedState;
        },
    }
}
