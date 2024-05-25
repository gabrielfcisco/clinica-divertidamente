import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        cors: true,
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],

    resolve: {
        alias: {
            "@": "/resources/js",
            // vue: "vue/dist/vue.esm-bundler.js",
        },
    },

    server: {
        host: '0.0.0.0',
        watch: {
            usePolling: true,
        },
        cors: {
            origin: '*',
        },
    },
});
