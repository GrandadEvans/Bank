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
        cy.login({id: 1});
        cy.visit({ route: 'transactions.index'});
    });

    beforeEach(() => {
        Cypress.Cookies.preserveOnce('laravel_session', 'banking_dev_session', 'XSRF-TOKEN');
    });

    it('allows us to create a single letter tag', () => {
        cy.scrollTo('topRight');
        cy.get('tbody tr').first().find('[data-cy=add-new-tag-icon]').click();
        cy.get('[data-cy=input-tag-name]', {timeout:10000}).wait(1000).type('new:The Letter A');
        cy.get('[data-cy=input-tag-icon]').clear().type('A');
        cy.get('[data-cy=tag-example] svg');
        cy.get('[data-cy=input-tag-icon]').clear().type('a');
        cy.get('[data-cy=tag-example] svg');
        cy.get('[data-cy=input-tag-bg-colour]').invoke('val', '#ff0000').trigger('change')
        cy.get('[data-cy=button-submit-tag]').click();
        cy.get('tbody tr').first().find('[data-cy=tag-1-1]');
    });

    it('lets us delete an icon', () => {
        cy.get('tbody tr').first().find('[data-cy=tags-list]').as('firstTagsList');
        cy.get('@firstTagsList').dblclick();
        cy.get('@firstTagsList').find('[data-cy=tag-delete-1-1]').click();
        cy.get('@firstTagsList').find('[data-cy=tag-delete-1-1]').should('not.exist');
    })
});
