import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js', 'resources/js/bootstrap.js', 'resources/js/validation_form.js', 'resources/js/font-awesome.js', 'resources/js/datatables.min.js'],
            refresh: true,
        }),
    ],
});
