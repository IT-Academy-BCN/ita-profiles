/// <reference types="vitest" />
import react from '@vitejs/plugin-react-swc'
import { defineConfig } from 'vite'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [react()],
    build: {
        outDir: 'build'
    },
    server: {
        port: 80,
        open: false,
        proxy: {
            '/api': {
                target: 'https://ita-profiles.onrender.com',
                changeOrigin: true,
                rewrite: (path) => path.replace(/^\/api/, '')
            }
        }
    },
    test: {
        globals: true,
        environment: 'jsdom',
        setupFiles: './src/__tests__/setup.ts',
        coverage: {
            provider: 'v8',
            reporter: ['lcov', 'text']
        }
    }
})
