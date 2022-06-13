describe('transactions.spec', () => {
    describe('We can edit existing remarks', () => {

        beforeEach(() => {
            Cypress.Cookies.preserveOnce()
        });
        before(() => {
            Cypress.Cookies.debug(true);
            const validTxData = {
                'icon': 'fa-brands fa-cc-visa',
                'tag': 'Test tag name',
                'default_color': '#000000',
                'contrasted_color': "white",
            };
            const validPropsData = {
                'icon': 'fa-brands fa-cc-visa',
                'tag': 'Test tag name',
                'id': 2,
                'default_color': '#000000',
                'contrasted_color': "white",
                'mode': 'list',
                'transaction_id': 34,
                'index': 3
            };
            cy.refreshDatabase();
            cy.seed('BaseSeeder');
            cy.create('Bank\\Models\\User')
            cy.create('Bank\\Models\\Transaction', 1, {user_id: 1})
            cy.create('Bank\\Models\\Transaction', 1, {user_id: 1})
            cy.create('Bank\\Models\\Tag', 1, validTxData)
            cy.login({id: 1});
        });

        it('has a link to add a manual transaction', () => {
            cy.visit({route:'transactions.index'})
            cy.wait(3000).get('tbody > tr:eq(0)').find('[data-cy=transaction-row-edit]');
            cy.get('tbody > tr:eq(0)').find('[data-cy=transaction-row-remarks]').click();
            cy.get('[data-cy=modal-remark-edit]', {timeout: 10000}).wait(1000).type('Test Remark 1');
            cy.get('[data-cy=modal-remark-submit]').click();
            cy.get('tbody > tr:eq(0)').find('[data-cy=transaction-row-remarks]').contains('Test Remark 1');
            cy.visit({route:'transactions.index'})
            cy.wait(3000).get('tbody > tr:eq(1)').find('[data-cy=transaction-row-edit]');
            cy.get('tbody > tr:eq(1)').find('[data-cy=transaction-row-remarks]').click();
            cy.get('[data-cy=modal-remark-edit]', {timeout: 10000}).wait(1000).type('Test Remark 2');
            cy.get('[data-cy=modal-remark-submit]').click();
            cy.get('tbody > tr:eq(1)').find('[data-cy=transaction-row-remarks]').contains('Test Remark 2');
        })
    })
})
