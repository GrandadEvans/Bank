import {mount} from '@vue/test-utils'
import Search from '@/components/search.vue'
import {axios} from 'axios';

describe('Test the allowed parameters', () => {
    it('an empty string should be rejected', () => {
        let results = axios.post('/search', {
            search: ''
        });
        console.dir(results);
        // expect(results).
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
