import { defineConfig } from '@playwright/test'

export default defineConfig({
  testDir: './tests/Browser',
  testMatch: 'seo.spec.ts',
  workers: 1,
  reporter: 'list',
  use: { baseURL: process.env.BASE_URL ?? 'http://127.0.0.1:8765', browserName: 'chromium', reducedMotion: 'reduce' },
})
