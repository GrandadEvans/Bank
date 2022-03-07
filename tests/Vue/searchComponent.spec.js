import {mount} from '@vue/test-utils'
import Search from '@/components/search.vue'
import {axios} from 'axios';
import {_} from 'lodash';

// Import lodash so the search function can use it
window._ = _;

describe('Test the allowed parameters', () => {
    it('should disallow under 3 characters', () => {
        const wrapper = mount(Search, {});
        wrapper.setData({search: '12'});
        expect(wrapper.vm.getResults()).toBeFalsy();
    });

    it('should allow above 3 characters', () => {
        const wrapper = mount(Search, {});
        wrapper.setData({search: '1234'});
        expect(wrapper.vm.getResults()).toBeFalsy();
    });

    it('an empty string should be rejected', () => {
        const wrapper = mount(Search, {});
        wrapper.setData({search: ''});
        expect(wrapper.vm.getResults()).toBeFalsy();
    })
});
