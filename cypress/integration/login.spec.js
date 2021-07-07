const emails = {
    'correct': 'john@grandadevans.com',
    'incorrect': 'john1@grandadevans.com'
};
const passwords = {
    'incorrect': {
        'text': 'password1',
        'hash': '$2b$10$OJJSGP51WCAp.1/sGwXnqOpOGL72m2j9UTmc4CA9soRY7iqb6Pt5.'
    },
    'correct': {
        'text': 'password',
        'hash': '$2b$10$1XJthrfGRhrbsP21EKHIlOeH4aUlC9RZJFMu0WWpph.xkUhcO.hJe'
    }
}

before(() => {
    cy.artisan('migrate:fresh').then(() => {
        cy.seed('BaseSeeder')
        cy.create('Bank\\Models\\User', 1, {
            'email': emails.correct,
            'password': passwords.correct.hash
        })
    });
});

describe('Check the Login page', () => {
    it('checks the home page login link works', () => {
        cy.visit('/');
        cy.get('.login-link').click();
        cy.url().should('include', '/login');
    });

    it('check the form error for incorrect email', () => {
        cy.visit('/login');
        cy.get('#email').type(emails.incorrect);
        cy.get('#password').type(passwords.incorrect.text);
        cy.get('#submit').click()
        cy.get('form#login-form').contains('These credentials do not match our records.');
    })

    it('check the form error for incorrect email', () => {
        cy.visit('/login');
        cy.get('#email').type(emails.correct);
        cy.get('#password').type(passwords.incorrect.text);
        cy.get('#submit').click()
        cy.get('form#login-form').contains('These credentials do not match our records.');
    })

    it('diverts to dashboard if logged in', () => {
        cy.login();
        cy.visit('/login');
        cy.url().should('include', '/home');
        cy.wait(1000)
    })
})
