// register.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test

const correctPassword = 'password123';
const incorrectPassword = `${correctPassword}1`;

describe('Make sure the web page exists', () => {
    it('Check the page exists', () => {
        cy.exec('php artisan migrate:fresh --seed')

        cy.visit('http://192.168.0.3:8000')
    });
});

describe('Check the form behaves properly', () => {
    it('It catches if passwords don\'t match', () => {
        cy.get('.registration-link').click()

            .get('#name').type('John Evans')
            .get('#email').type('john@grandadevans.com')
            .get('#password').type(correctPassword)
            .get('#password-confirm').type(incorrectPassword)
            .get('#submit').click()

            .get('form#registration-form')
            .contains('The password confirmation does not match.')
            .get('#password').type(correctPassword)
            .get('#password-confirm').type(correctPassword)
            .get('#submit').click()
    })
    it('It catches if email address already exists', () => {
        cy.get('.registration-link').click()

            .get('#name').type('John Evans')
            .get('#email').type('john@grandadevans.com')
            .get('#password').type(correctPassword)
            .get('#password-confirm').type(incorrectPassword)
            .get('#submit').click()

            .get('form#registration-form')
            .contains('The password confirmation does not match.')
            .get('#password').type(correctPassword)
            .get('#password-confirm').type(correctPassword)
            .get('#submit').click()
    })
})
