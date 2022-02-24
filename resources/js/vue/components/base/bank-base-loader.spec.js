import {mount} from '@cypress/vue';
import BankBaseLoader from './bank-base-loader.vue';

it('bank-base-loader', () => {
    mount(BankBaseLoader, {});

    cy.get('bank-base-loader').contains('Loading...');
})
