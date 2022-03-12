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

Cypress.Commands.add('resetWithFullSeed', () => {
    const filePath = './database/full-seed-dump-2022_03_10_00_04_37.sql';
    const command = `/bin/mysql /
        -u ${Cypress.env('DB_USERNAME')} /
        -p${Cypress.env('DB_PASSWORD')} /
        -h ${Cypress.env('DB_HOST')} /
        ${Cypress.env('DB_DATABASE')} /
        < ${filePath}`;
    cy.exec(command, {log: false, timeout: 60000});
});

Cypress.Commands.add('deleteTags', () => {
    const query = `truncate table ${Cypress.env('DB_DATABASE')}.tags; truncate table ${Cypress.env('DB_DATABASE')}.tag_transaction;`;
    const command = `/bin/mysql \
        -h ${Cypress.env('DB_HOST')} \
        -p${Cypress.env('DB_PASSWORD')} \
        -u ${Cypress.env('DB_USERNAME')} \
        ${Cypress.env('DB_DATABASE')} \
        -e "${query}"`;
    cy.exec(command, {timeout: 5000}, (result) => {log: 'Result Code: ' + result.code});
});

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
