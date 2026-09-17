import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes(`${'node_modules'}/alpinejs`) || id.includes(`${'node_modules'}${'\\'}alpinejs`)) {
                        return 'alpine';
                    }
                    if (id.includes(`${'node_modules'}/gsap`) || id.includes(`${'node_modules'}${'\\'}gsap`)) {
                        return 'gsap';
                    }
                },
            },
        },
    },
});
