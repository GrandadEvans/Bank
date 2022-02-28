const correctPassword = 'password123';
const incorrectPassword = `${correctPassword}1`;
const email = 'john@grandadevans.com';
const distinctEmail = 'john1@grandadevans.com';

const loginDetails = {'email': email, 'password': correctPassword};

before(() => {
    cy
        .artisan('migrate:fresh')
        .seed('BaseSeeder')
        .create('Bank\\Models\\User', 1, loginDetails)
        .login(loginDetails);
});

describe('Test the transaction section', () => {
    it('has a link to add a manual transaction', () => {
        cy.visit('/home')
        // cy.route('transactions.create');
        cy.get('a[href*="/transactions/create"]').scrollIntoView().click('center', {force: true});
        cy.get('h1').contains('Add a new manual trasaction');
    })
})
