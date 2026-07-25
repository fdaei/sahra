import { defineConfig, devices } from '@playwright/test'

/**
 * Responsive + accessibility smoke tests.
 *
 * Viewport widths mirror docs/RESPONSIVE-QA.md (Phase 7): the design's two
 * real breakpoints (402 mobile, 1440 desktop) plus the derived tablet range.
 *
 * Run: npm run test:e2e
 * Requires the app running locally at BASE_URL (default http://localhost:8000).
 */
export default defineConfig({
  testDir: './tests/Browser',
  fullyParallel: true,
  retries: process.env.CI ? 2 : 0,
  reporter: [['html', { open: 'never' }]],

  use: {
    baseURL: process.env.BASE_URL ?? 'http://localhost:8000',
    trace: 'on-first-retry',
  },

  projects: [
    { name: 'mobile-360', use: { ...devices['Pixel 5'], viewport: { width: 360, height: 800 } } },
    { name: 'mobile-390', use: { ...devices['iPhone 12'], viewport: { width: 390, height: 844 } } },
    { name: 'mobile-414', use: { viewport: { width: 414, height: 896 } } },
    { name: 'tablet-768', use: { viewport: { width: 768, height: 1024 } } },
    { name: 'tablet-1024', use: { viewport: { width: 1024, height: 1366 } } },
    { name: 'desktop-1440', use: { viewport: { width: 1440, height: 900 } } },
    { name: 'desktop-1920', use: { viewport: { width: 1920, height: 1080 } } },
  ],
})
