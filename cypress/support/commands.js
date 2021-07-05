// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

Cypress.Commands.add('register', (
    name = 'John Evans',
    email = 'john@grandadevans',
    password = 'password',
    passwordConfirm = 'password',
    options = {}
    ) => {

    if (options.migrate && options.migrate === true) {
        cy.exec('php artisan migrate:fresh --seed');
    }

    cy.visit('http://192.168.0.3:8000')
        .get('#name').type(name)
        .get('#email').type(email)
        .get('#password').type(password)
        .get('#password-confirm').type(passwordConfirm)
        .get('#submit').click();

});

Cypress.Commands.overwrite('type', (originalFn, element, text, options) => {
    if (options && options.sensitive) {
        // turn off original log
        options.log = false
        // create our own log with masked message
        Cypress.log({
            $el: element,
            name: 'type',
            message: '*'.repeat(text.length),
        })
    }

    return originalFn(element, text, options)
})
