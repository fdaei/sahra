import { chromium } from '@playwright/test'

const base = process.env.BASE_URL ?? 'http://127.0.0.1:8000'
const paths = (process.env.SEO_PATHS ?? '/en,/en/about,/en/services,/en/work,/en/insights,/fa,/ar').split(',')
const browser = await chromium.launch()
const context = await browser.newContext({ javaScriptEnabled: false })
try {
  for (const path of paths) {
    const page = await context.newPage()
    const response = await page.goto(new URL(path, base).href)
    const checks = {
      status: response?.status() === 200,
      title: (await page.title()).trim().length > 0,
      description: Boolean(await page.locator('meta[name="description"]').getAttribute('content')),
      canonical: Boolean(await page.locator('link[rel="canonical"]').getAttribute('href')),
      h1: await page.locator('main h1').count() === 1,
      // Only visible body text counts; serialized props and JSON-LD do not.
      content: (await page.locator('main').innerText()).trim().length > 100,
      links: await page.locator('main a[href]').count() > 0,
    }
    if (!Object.values(checks).every(Boolean)) {
      console.error(path, checks)
      process.exitCode = 1
    } else console.log(`PASS ${path}: real PHP HTML, JavaScript disabled`)
    await page.close()
  }
} finally {
  await browser.close()
}
