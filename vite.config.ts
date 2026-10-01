import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'node:path'

export default defineConfig(() => ({
  plugins: [
    laravel({
      input: ['resources/js/app.ts'],
      refresh: [
        'resources/views/**',
        'routes/**',
        'app/Http/Controllers/**',
        'lang/**',
      ],
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
      '@': path.resolve(__dirname, 'resources/js'),
      '~img': path.resolve(__dirname, 'resources/images'),
    },
  },

  build: {
    // Long-cached hashed assets; the manifest tells Laravel what to emit.
  },

  ssr: {
    noExternal: ['@inertiajs/vue3', 'ziggy-js'],
  },

  server: {
    host: '127.0.0.1',
    hmr: { host: '127.0.0.1' },
  },
}))
