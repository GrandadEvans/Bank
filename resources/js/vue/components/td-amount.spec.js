import {mount} from '@cypress/vue';
import Cell from './td-amount.vue';

it('is has a valid currency symbol', () => {
    mount(Cell);

    cy.get('div').contains('£');
})
