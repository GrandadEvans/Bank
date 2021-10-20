const importURL = '/transactions/import';

before(() => {
    cy.artisan('migrate:fresh').then(() => {
        cy.seed('BaseSeeder')
    });
});

beforeEach(() => {
    cy.login();
})

afterEach(() => {
    cy.wait(1000)
})

describe('Test the import functionality', () => {
    it('verifies we can\'t import unless logged in', () => {
        cy.logout()
        cy.visit(importURL)
        cy.url().should('include', '/login')
    })

    it('appears at the correct URL', () => {
        cy.visit(importURL)
        cy.get('h1').contains('Import Transactions')
    })

    it('has a form to enable us to upload', () => {
        cy.visit(importURL)
        cy.get('form#import-form').contains('input')
        cy.get('form#import-form').contains('button')
    })
})
