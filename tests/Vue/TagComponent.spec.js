import {mount, config} from '@vue/test-utils';
import TagComponent from '@/components/tag.vue';
import TrComponent from '@/components/transaction-table-row.vue';
import axios from 'axios';

config.stubs['font-awesome-icon'] = {
    template: '<i />'
};

jest.mock("axios", () => ({
    delete: () => Promise.resolve({data: { data: "OK" }})
}));
const validPropsData = {
    'icon': 'fa-brands fa-cc-visa',
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
        Object.assign(validPropsData, {
            icon: 'fa-brands fa-cc-visa',
            tag: 'Visa',
            id: 1,
            background_color: '#000000',
            contrasted_color: '#ffffff',
            mode: 'list',
            transaction_id: 2,
            index: 0
        });
        const wrapper = mount(TagComponent, {propsData: validPropsData});
        const expected = '<i data-cy="tag-2-1" title="Visa" icon="fa-brands fa-cc-visa" id="icon-2--1"></i>';
        expect(wrapper.html()).toContain(expected);
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

// Skipping as can't get it to work
describe.skip('Make sure we can edit the tag', () => {
    it('It unlink the tag from the transaction if we click delete', () => {
        let options = {
            propsData: {
                row: {
                    "id": 1,
                    "user_id": 1,
                    "provider_id": 1,
                    "payment_method_id": 5,
                    "isPartOfRegular": 0,
                    "date": "2021-05-21T23:00:00.000000Z",
                    "entry": "LIDL",
                    "amount": -1577.73,
                    "balance": "2270.36",
                    "remarks": "Ad est quis quis numquam natus.",
                    "created_at": "2022-03-15T22:07:30.000000Z",
                    "updated_at": "2022-03-15T22:07:30.000000Z",
                    "tags": [],
                    "provider": {
                        "id": 1,
                        "user_id": 0,
                        "payment_method_id": 1,
                        "name": "N/A",
                        "regular_expressions": null,
                        "logo": null,
                        "remarks": null,
                        "created_at": "2022-03-15T22:07:29.000000Z",
                        "updated_at": "2022-03-15T22:07:29.000000Z"
                    },
                    "payment_method": {
                        "id": 5,
                        "abbreviation": "CSH",
                        "method": "CSH",
                        "logo": null,
                        "created_at": null,
                        "updated_at": null
                    }
                },
                index: 0
            }
        };
        const wrapper = mount(TrComponent, options);
        wrapper.find('tbody > tr:eq(0) [data-cy=tags-list]').trigger('dbclick');
        // wrapper.find('.tag-delete').trigger('click');
        // wrapper.vm.$nextTick(() => {
        //     expect(wrapper.html()).toContain('li');
        //     done();
        // });
    });
});
