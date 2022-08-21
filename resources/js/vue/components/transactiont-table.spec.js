import TransactionTable from './transaction-table'
import transactions from '../../../../cypress/fixtures/transactions.page1_25records.json'

describe('test the transaction component', () => {
    it('recorgnises when transactions are loaded', () => {
        cy.mount(TransactionTable)

        cy
    })
})
