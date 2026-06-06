import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import en from './locales/en.json';
import vi from './locales/vi.json';
import { vWanakana } from './Directives/wanakana';

const i18n = createI18n({
    legacy: false, // use Composition API
    locale: 'vi', // set default locale
    fallbackLocale: 'en',
    messages: {
        en,
        vi
    }
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue)
            .directive('wanakana', vWanakana)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
// Trigger HMR
