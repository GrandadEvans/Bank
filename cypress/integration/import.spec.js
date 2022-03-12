const importURL = '/transactions/import';

describe('import.spec', () => {
    describe('Test the import functionality', () => {
        before(() => {
            cy.resetWithFullSeed();
        });

        beforeEach(() => {
            cy.login();
        })

        afterEach(() => {
            cy.wait(1000)
        })

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
            cy.get('form#import-form input')
            cy.get('form#import-form button')
        })
    })
})
