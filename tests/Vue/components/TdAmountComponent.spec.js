import {mount} from '@vue/test-utils';
import Cell from '@/components/td-amount.vue';

describe('testing the way the passed amount is presented', () => {
    const cell = mount(Cell, {
        propsData: {
            currency: 'GBP',
            amount: -23.65,
            symbol: '£',
            prepend: '',
            post: '',
            formatted: null
        }
    });
    it('is has a valid currency symbol', () => {
        expect(cell.html()).toContain('£');
    })

    it('displays in the correct format', () => {
        expect(cell.html()).toContain('-£23.65');
    })

    it('has the negative class', () => {
        expect(cell.html()).toContain('currency-negative');
    })

    it('has the positive class', () => {
        cell.setProps({amount: '23.66'})
        expect(cell.html()).toContain('currency-positive');
    })
});
