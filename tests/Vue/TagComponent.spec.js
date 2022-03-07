import {mount, config} from '@vue/test-utils';
import TagComponent from '@/components/tag.vue';
import axios from 'axios';

config.stubs['font-awesome-icon'] = '<i />';

jest.mock("axios", () => ({
    delete: () => Promise.resolve({data: { data: "OK" }})
}));
const validPropsData = {
    'icon': 'fa-solid fa-circle',
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
        Object.assign(validPropsData, {'icon': 'fa-brands fa-cc-visa'});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/<i title=\"Test tag name\" icon=\"fa-brands fa-cc-visa\"><\/i>/);
    });

    it('If there\'s NO icon, it should display a circle', () => {
        Object.assign(validPropsData, {'icon': null});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/<i icon=\"fa-solid fa-circle\"><\/i>/);
    });
});

describe('Make sure we can create a new tag', () => {
    it('should accept tags of a single character', () => {
        Object.assign(validPropsData, {'icon': 'fa-solid fa-a'});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/fa-solid fa-a/);
    });

    it('should default to a solid tag if style is not specified', () => {
        Object.assign(validPropsData, {'icon': 'fa-solid fa-cat'});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/fa-solid fa-cat/);
    });

    it('should allow us to create other types of icons (brands)', () => {
        Object.assign(validPropsData, {'icon': 'fa-brands fa-cc-visa'});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/fa-brands fa-cc-visa/);
    });

    it('should allow us to create other types of icons (regular)', () => {
        Object.assign(validPropsData, {'icon': 'fa-regular fa-car'});
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        expect(wrapper.html()).toMatch(/fa-regular fa-car/);
    });
});
describe('Make sure we can edit the tag', () => {
    it('It unlink the tag from the transaction if we click delete', done => {
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        const deleteLink = wrapper.find('.tag-delete'); // nth selector from memory
        wrapper.find('.tag-delete').trigger('click');

        wrapper.vm.$nextTick(() => {
            expect(wrapper.emitted('deleteTag')).toBeTruthy();
            done();
        });
    });
});
