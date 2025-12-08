import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        // Configuration SIMPLIFIÉE - supprimez la configuration babel
        react(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/register.css',
                'resources/js/app.jsx'  // Un seul point d'entrée
            ],
            refresh: [
                'resources/views/**/*.blade.php',
                'resources/js/**/*.jsx',
                'resources/css/**/*.css'
            ],
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    server: {
        host: '127.0.0.1',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
    },
});
