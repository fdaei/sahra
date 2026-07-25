import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'node:path'

export default defineConfig({
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
    rollupOptions: {
      output: {
        manualChunks: {
          // GSAP is ~70kb and only needed once the page is interactive.
          gsap: ['gsap'],
          vendor: ['vue', '@inertiajs/vue3'],
        },
      },
    },
  },

  server: {
    host: '127.0.0.1',
    hmr: { host: '127.0.0.1' },
  },
})
