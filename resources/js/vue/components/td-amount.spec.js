import Cell from './td-amount.vue';

describe('Test the amount component', () => {
    it('is has a valid currency symbol', () => {

        cy.mount(Cell, {
            props: {
                currency: 'GBP',
                amount: 99.99,
                symbol: '£',
            },
            propsData: {
                currency: 'GBP',
                amount: 99.99,
                symbol: '£',
            }
        })
        .get('div')
            .should('have.class', 'currency-amount')
            .should('have.class', 'currency-positive')
    })


    it('negative amounts reflect in class list', () => {
        cy.mount(Cell, {
            propsData: {
                currency: 'GBP',
                amount: -99.99,
                symbol: '£'
            }
        })

        cy.get('div')
            .should('have.class', 'currency-amount')
            .should('have.class', 'currency-negative')
            .should('contain', '-£99.99')
    })
})
