const loginDetails = {
    'correct': 'john@grandadevans.com',
    'text': 'password',
    'hash': '$2b$10$1XJthrfGRhrbsP21EKHIlOeH4aUlC9RZJFMu0WWpph.xkUhcO.hJe'
};

describe.skip('tags.jest', () => {
describe('We should be able to interact from the transactions table', () => {
    it('allows us to create a single letter tag', () => {
        cy.exec('/bin/mysql -u john -p95T0zmye -h 192.168.0.3 bank_test < /home/john/Projects/bank/database/full-seed-dump-2022_03_10_00_04_37.sql');
        cy.login();
        cy.visit({ route: 'transactions.index'}).wait(5000);

        // it('we have an add icon button', () => {
            cy.get('[data-cy=add-new-tag-icon]').click();
        // })
        // it('tag name field', () => {
            cy.get('[data-cy=input-tag-name]').type('new:The Letter A');
        // });
        // it.skip('tag icon field - uppercase', () => {
            cy.get('[data-cy=input-tag-icon]').type('A');
            cy.get('[data-cy=tag-example] svg');
        // })
        // it.skip('tag icon field - lowercase', () => {
            cy.get('[data-cy=input-tag-icon]').clear();
            cy.get('[data-cy=input-tag-icon]').type('a');
            cy.get('[data-cy=tag-example] svg');
        // })
        // it.skip('tag-colour field', () => {
            cy.get('[data-cy=input-tag-bg-colour]').invoke('val', '#ff0000').trigger('change')
        // })
        // it.skip('form buttons', () => {
        cy.get('[data-cy=button-add-tag]').click();
        // flushPromises();
        cy.get('[data-cy=taglist-1] [data-cy=icon-999]');
        // @todo test html of tag
        // cy.create('Tag', {
        //     id: 999,
        //     name: 'see',
        //     icon: 'fa-solid fa-arrow-down-short-wide',
        //     created_by_user: 1,
        //     default_color: '#000000',
        //     contrasted_color: '#FFFFFF'
        // });
        cy.get('[data-cy=transaction-row-1] [data-cy-taglist-1]');
    // })
    })
})
})
