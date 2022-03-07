import {mount} from '@cypress/vue';
import BankBaseLoader from './bank-base-loader.vue';

describe('BankBaseLoader', () => {
    it('is a valid loader', () => {
        const wrapper = mount(BankBaseLoader.default);

        expect(wrapper.find('div').text()).toEqual('Loading...');
    });
});
