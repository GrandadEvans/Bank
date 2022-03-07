const correctPassword = 'password123';
const incorrectPassword = `${correctPassword}1`;
const email = 'john@grandadevans.com';
const distinctEmail = 'john1@grandadevans.com';

describe('Check the Registration page', () => {
    before(() => {
        cy.artisan('migrate:fresh').then(() => {
            cy.seed('BaseSeeder')
            cy.create('Bank\\Models\\User', 1, {
                'email': email
            })
        });
    });

    beforeEach(() => {
        cy.logout();
    })

    beforeEach(() => {
    })
    it('checks the home page registration link works', () => {
        cy.visit('/');
        cy.get('#navbarDropdownGuest').click();
        cy.get('.register-link').click();
        cy.url().should('include', '/register');
    });

    it('check the registration form works', () => {
        cy.visit('/register');
        cy.get('#navbarDropdownGuest');
        cy.get('#name').type('John Evans');
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
