describe('Test the transaction section', () => {
    before(() => {
        cy.artisan('migrate:fresh')
        cy.artisan('db:seed BaseSeeder')
        cy.login();
    });

    it('has a link to add a manual transaction', () => {
        cy.visit('/home')
        cy.get('#sidebarMenu');
        // cy.route('transactions.create');
        cy.get('a[href*="/transactions/create"]').click();
        cy.get('h1').contains('Add a new manual trasaction');
    })
})
