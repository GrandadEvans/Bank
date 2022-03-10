import {mount} from '@vue/test-utils'
import Search from '@/components/search.vue'
import {axios} from 'axios';

describe('Test the allowed parameters', () => {
    it('should disallow under 3 characters', () => {
        const wrapper = mount(Search, {});
        wrapper.search = '12';
        expect(wrapper.attributes('getResults')).toBeFalsy();
    });
    it('an empty string should be rejected', () => {
        const wrapper = mount(Search, {});
        wrapper.setData({search: ''});
        expect(wrapper.attributes('getResults')).toMatch(null);
    })
});
