import { mount } from '@vue/test-utils'
import CommentsComponent from './CommentsComponent.vue'

function mockFetch(data) {
    return jest.fn().mockImplementation(() =>
        Promise.resolve({
            ok: true,
            json: () => data
        })
    );
}

describe('CommentsComponent', () => {
    window.fetch = mockFetch({}); // or window.fetch
    const wrapper = mount(CommentsComponent)

    it('is a Vue instance', () => {
        expect(wrapper.isVueInstance()).toBeTruthy()
    })
})