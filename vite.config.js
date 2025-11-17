import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import fs from 'fs';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.jsx',
            refresh: true
        }),
        react()
    ],
    resolve: {
        alias: {
            // '@': 'resources/js/Pages',
            // '@component': 'resources/js/Pages/Components/',
            // '@images': './images'
        }
    },
    server: {
        // host: '0.0.0.0', // Allow access from the network
        // port: 5173, // Change if needed
        // https: {

        //  key: fs.readFileSync('./ssl/key.pem'),
        //     cert: fs.readFileSync('./ssl/cert.pem')

        // },
        // hmr: {
        //     protocol: 'wss', // Use secure WebSocket
        //     host: 'vividsmile.projeweb.site'
        // }
    }
});
