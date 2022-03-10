describe('sidebar.spec', () => {
    describe('Test the transaction section', () => {
        before(() => {
            cy.refreshDatabase();
            cy.seed('BaseSeeder');
            cy.login();
        });

        it('has a link to add a manual transaction', () => {
            cy.visit({route:'home'})
            cy.wait(3000).get('[data-cy=sidebar-link_dashboard]').scrollIntoView();
            cy.get('[data-cy=sidebar-link_transaction-add]').click();
            cy.get('h1').contains('Add a new manual trasaction');
        })
    })
})
