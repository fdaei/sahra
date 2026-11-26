import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/public.js'],
      refresh: ['resources/views/**', 'routes/**', 'app/Http/Controllers/**', 'lang/**'],
    }),
  ],
  server: {
    host: '127.0.0.1',
    hmr: { host: '127.0.0.1' },
  },
})
