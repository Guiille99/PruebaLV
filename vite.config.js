import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js', 'resources/js/bootstrap.js', 'resources/js/jquery-3.6.3.js', 'resources/js/validation_form.js', 'resources/js/font-awesome.js'],
            refresh: true,
        }),
    ],
});
