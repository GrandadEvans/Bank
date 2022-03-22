const name = 'John Evans';
const correctPassword = 'password123';
const incorrectPassword = `${correctPassword}1`;
const email = 'john1@grandadevans.com';
const distinctEmail = 'john2@grandadevans.com';

describe('register.spec.js', () => {
    describe('Check the Registration page', () => {
        before(() => {
            cy.resetWithFullSeed();
            cy.create('Bank\\Models\\User', {email: email})
        });

        beforeEach(() => {
            cy.logout();
        })

        it('checks the home page registration link works', () => {
            cy.visit('/');
            cy.get('[data-cy=navbarDropdownGuest]').click();
            cy.get('[data-cy=registration-link]').click();
            cy.url().should('include', '/register');
        });

        it('check the registration form works', () => {
            cy.visit('/register');
            cy.get('[data-cy=navbarDropdownGuest]');
            cy.get('#name').type(name);
            cy.get('#email').type(email);
            cy.get('#password').type(correctPassword);
            cy.get('#password-confirm').type(incorrectPassword);
            cy.get('#submit').click()
            cy.get('#navbarDropdownGuest');
            cy.get('form#registration-form').contains('The password confirmation does not match.');
            cy.get('form#registration-form').contains('The email has already been taken.');
            cy.get('#password').clear().type(correctPassword);
            cy.get('#password-confirm').clear().type(correctPassword);
            cy.get('#email').clear().type(distinctEmail);
            cy.get('#submit').click();
            cy.wait(1000)
        })

        it('diverts to dashboard if logged in', () => {
            cy.login();
            cy.visit('/register');
            cy.url().should('include', '/home');
            cy.wait(1000)
        })
    })
});
