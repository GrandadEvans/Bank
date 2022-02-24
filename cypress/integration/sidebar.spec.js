before(() => {
    cy.artisan('migrate:fresh')
    cy.artisan('db:seed BaseSeeder')
    cy.login();
});

describe('Test the transaction section', () => {
    it('has a link to add a manual transaction', () => {
        cy.visit('/home')
        // cy.route('transactions.create');
        cy.get('a[href*="/transactions/create"]').scrollIntoView().click('center', {force: true});
        cy.get('h1').contains('Add a new manual trasaction');
    })
})
