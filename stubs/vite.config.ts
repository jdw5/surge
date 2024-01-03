import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { watch } from "vite-plugin-watch"
// import eslintPlugin from "vite-plugin-eslint"

export default defineConfig(({ ssrBuild }) => {
    return {
        plugins: [
            laravel({
                input: 'resources/js/app.ts',
                ssr: "resources/js/ssr.ts",
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
                script: {
                    defineModel: true,
                },
            }),
            watch({
                pattern: "app/{Data,Enums}/**/*.php",
                command: "php artisan typescript:transform",
                onInit: !ssrBuild,
            }),
        ],
    }
});
