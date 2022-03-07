const loginDetails = {
    'correct': 'john@grandadevans.com',
    'text': 'password',
    'hash': '$2b$10$1XJthrfGRhrbsP21EKHIlOeH4aUlC9RZJFMu0WWpph.xkUhcO.hJe'
};

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
        cy.visit({ route: 'home' });
        cy.get('[data-cy=navbarDropdownGuest]').click();
        cy.get('[data-cy=registration-link]').click();
        cy.url().should('include', '/register');
    });
})

describe('Check we see the correct links for authorised users', () => {
    it('checks the logout link works', () => {
        cy.refreshDatabase();
        cy.seed('BaseSeeder');
        cy.login();
        cy.visit({route: 'home'}).wait(2000);
        cy.get('[data-cy=navbarDropdownAuth]').click();
        cy.get('[data-cy=logout-link]').click();
        cy.get('[data-cy=navbarDropdownGuest]')
    });
})

describe('There should be a link to the home page...', () => {
    it('...appears when logged in', () => {
        cy.refreshDatabase();
        cy.seed('BaseSeeder');
        cy.login();
        cy.get('[data-cy=home-link]').click();
        cy.url().should('match', /\/home$/);
    });

    it('...appears when logged out', () => {
        cy.logout().wait(2000);
        cy.get('.navbar').scrollTo('top');
        cy.get('[data-cy=home-link]').click();
        cy.url().should('match', /\/login$/);
    })
})
