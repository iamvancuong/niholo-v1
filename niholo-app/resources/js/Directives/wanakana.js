import * as wanakana from 'wanakana';

export const vWanakana = {
    mounted(el, binding) {
        // Initialize wanakana on the element (must be an input or textarea)
        // options can be passed via binding.value
        wanakana.bind(el, binding.value || {});
    },
    unmounted(el) {
        wanakana.unbind(el);
    }
};
