import {mount} from '@vue/test-utils'
import Search from '@/components/search.vue'
import {axios} from 'axios';

describe('Test the allowed parameters', () => {
    it('should disallow under 3 characters', () => {
        const wrapper = mount(Search, {});
        wrapper.search = '12';
        expect(wrapper.getResults()).toBeFalsy();
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
//
// describe('Make sure we can edit the tag', () => {
//     it('It unlink the tag from the transaction if we click delete', () => {
//         import axios from 'axios';
//         jest.mock('axios');
//
//         let url = `/transactions/${validPropsData.transaction_id}/unlink_tag/${validPropsData.id}`;
//         axios.get.mockResolvedValue({data: 'OK'});
//         const wrapper = mount(TagComponent, {propsData: validPropsData});
//         const deleteLink = wrapper.find()
//         return Users.all().then(data => expect(data).toEqual(users));
//         });
//     })
// })
