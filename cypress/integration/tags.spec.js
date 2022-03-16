
const loginDetails = {
    'correct': 'john@grandadevans.com',
    'text': 'password',
    'hash': '$2b$10$1XJthrfGRhrbsP21EKHIlOeH4aUlC9RZJFMu0WWpph.xkUhcO.hJe'
};

describe('tags.spec', () => {
    before(() => {
        const validTxData = {
            'icon': 'fa-brands fa-cc-visa',
            'tag': 'Test tag name',
            'default_color': '#000000',
            'contrasted_color': "white",
        };
        const validPropsData = {
            'icon': 'fa-brands fa-cc-visa',
            'tag': 'Test tag name',
            'id': 2,
            'default_color': '#000000',
            'contrasted_color': "white",
            'mode': 'list',
            'transaction_id': 34,
            'index': 3
        };
        cy.refreshDatabase();
        cy.seed('BaseSeeder');
        cy.create('Bank\\Models\\User')
        cy.create('Bank\\Models\\Transaction', 1, {user_id: 1})
        cy.create('Bank\\Models\\Tag', 1, validTxData)
        cy.login({id: 1});
        cy.visit({ route: 'transactions.index'});
    });

    it('lets us delete an icon', () => {
        cy.wait(5000).scrollTo('topRight');
        cy.get('tbody > tr:eq(0)').find('[data-cy=tags-list]').trigger('dblclick');

    })

    describe.skip('We should be able to interact from the transactions table', () => {
        it('allows us to create a single letter tag', () => {
            cy.scrollTo('topRight');
            cy.get('tbody tr').first().find('[data-cy=add-new-tag-icon]').click().wait(5000);
            cy.get('[data-cy=input-tag-name]').type('new:The Letter A');
            cy.get('[data-cy=input-tag-icon]').clear().type('A');
            cy.get('[data-cy=tag-example] svg');
            cy.get('[data-cy=input-tag-icon]').clear().type('a');
            cy.get('[data-cy=tag-example] svg');
        });

        it('allows us to select a colour', () => {
            cy.get('[data-cy=input-tag-bg-colour]').invoke('val', '#ff0000').trigger('change')
        });

        it('checks the modal submit buttons work', () => {
            cy.get('[data-cy=button-submit-tag]').click().wait(5000);
            cy.get('.tags_list').first().find('[data-cy=icon]');
        });
    });
});
