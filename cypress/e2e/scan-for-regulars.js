// scan-for-regulars.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test

before(() => {
    cy.resetWithFullSeed();
    cy.create('Bank\\Models\\User', 1, {
        'email': email
    })
});