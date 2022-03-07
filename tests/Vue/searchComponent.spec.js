import {mount} from '@vue/test-utils'
import Search from '@/components/search.vue'
import {axios} from 'axios';

describe('Test the allowed parameters', () => {
    it('should disallow under 3 characters', () => {
        const wrapper = mount(Search, {});
        wrapper.search = '12';
        expect(wrapper.getResults()).toBeFalsy();
    });

    it('should allow above 3 characters', () => {
        const wrapper = mount(Search, {});
        wrapper.setData({search: '1234'});
        expect(wrapper.vm.getResults()).toBeFalsy();
    });

    it('an empty string should be rejected', () => {
        const wrapper = mount(Search, {});
        wrapper.setData({search: ''});
        expect(wrapper.getResults()).toMatch(null);
        // .toMatch(/fab fa-visa/);        let results = axios.post('/search', {
        //     term: ''
        // });
        // console.dir(results);
        // expect(results).toMatch('test');
    })
});
