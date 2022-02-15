import {mount} from '@vue/test-utils';
import TagComponent from '@/components/tag.vue';

const validPropsData = {
    'icon': 'fa fa-circle',
    'tag': 'Test tag name',
    'id': 2,
    'background_color': '#000000',
    'contrasted_color': "white",
    'mode': 'list',
    'transaction_id': 34,
    'index': 3
};
describe('Make sure the icons work ok', () => {
    it('If there\'s an icon, it should display', () => {
        let validIcon = Object.assign(validPropsData, {'icon': 'fab fa-visa'});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/fab fa-visa/);
    });

    it('If there\'s NO icon, it should display a circle', () => {
        let validIcon = Object.assign(validPropsData, {'icon': null});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/'fas fa-circle/);
    });
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
