const loginDetails = {
    'correct': 'john@grandadevans.com',
    'text': 'password',
    'hash': '$2b$10$1XJthrfGRhrbsP21EKHIlOeH4aUlC9RZJFMu0WWpph.xkUhcO.hJe'
};

describe('navbar.spec', () => {
    describe('Check we see the correct links for guests', () => {
        it('checks the login link works', () => {
            cy.logout();
            cy.visit({route: 'home'});
            cy.get('[data-cy=navbarDropdownGuest]').click();
            cy.get('[data-cy=login-link]').click();
            cy.url().should('include', '/login');
        });

        it('checks the registration link works', () => {
            cy.logout();
            cy.visit({route: 'home'});
            cy.get('[data-cy=navbarDropdownGuest]').click();
            cy.get('[data-cy=registration-link]').click();
            cy.url().should('include', '/register');
        });
    })

    describe('Check we see the correct links for authorised users', () => {
        it('checks the logout link works', () => {
            cy.resetWithFullSeed();
            cy.login();
            cy.visit({route: 'home'});
            cy.wait(5000);
            cy.get('[data-cy=navbarDropdownAuth]').scrollIntoView().click();
            cy.get('[data-cy=logout-link]').click();
            cy.wait(5000);
            cy.get('[data-cy=navbarDropdownGuest]')
        });
    })

    describe('There should be a link to the home page...', () => {
        it('...appears when logged in', () => {
            cy.resetWithFullSeed();
            cy.login();
            cy.wait(5000);
            cy.get('[data-cy=home-link]').scrollIntoView().click();
            cy.url().should('match', /\/home$/);
        });

        it('...appears when logged out', () => {
            cy.logout();
            cy.wait(5000);
            cy.get('[data-cy=home-link]').scrollIntoView().click();
            cy.url().should('match', /\/login$/);
        })
    })
})
