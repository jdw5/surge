import './bootstrap';
import '../css/app.css';

import { createApp, createSSRApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { modal } from "momentum-modal"

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title: string) => (title ? `${appName} — ${title}` : `${appName}`),
    resolve: (name: string) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    
    setup({ el, App, props, plugin }) {
        createSSRApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(modal, {
                resolve: (name: string) => resolvePageComponent(`./Modals/${name}.vue`, import.meta.glob<DefineComponent>('./Modals/**/*.vue'))                
            })
            .mount(el);
    },
    
    progress: {
        color: '#4B5563',
    },
});
