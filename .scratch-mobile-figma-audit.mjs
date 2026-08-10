import { chromium } from 'playwright'
import { mkdir, writeFile } from 'node:fs/promises'

const baseURL = 'http://127.0.0.1:8000'
const outputDir = 'AUDIT/mobile-figma/live'
await mkdir(outputDir, { recursive: true })

const browser = await chromium.launch({ executablePath: '/usr/bin/chromium' })
const context = await browser.newContext({
  viewport: { width: 402, height: 874 },
  deviceScaleFactor: 1,
  reducedMotion: 'reduce',
})
const page = await context.newPage()
const errors = []
page.on('pageerror', (error) => errors.push({ type: 'pageerror', message: error.message }))
page.on('console', (message) => {
  if (message.type() === 'error') errors.push({ type: 'console', message: message.text() })
})

const routes = [
  ['home', '/en'],
  ['work', '/en/work'],
  ['services', '/en/services'],
  ['about', '/en/about'],
  ['insights', '/en/insights'],
  ['contact', '/en/contact'],
  ['privacy', '/en/privacy-policy'],
  ['terms', '/en/terms'],
  ['error', '/en/not-a-real-page'],
]

await page.goto(`${baseURL}/en/work`, { waitUntil: 'networkidle' })
const workDetail = await page.locator('a[href*="/en/work/"]').first().getAttribute('href')
if (workDetail) routes.splice(2, 0, ['work-show', workDetail])

await page.goto(`${baseURL}/en/insights`, { waitUntil: 'networkidle' })
const insightDetail = await page.locator('a[href*="/en/insights/"]').first().getAttribute('href')
if (insightDetail) routes.splice(routes.findIndex(([, route]) => route === '/en/contact'), 0, ['insight-show', insightDetail])

const results = []
for (const [name, route] of routes) {
  const beforeErrors = errors.length
  const response = await page.goto(route.startsWith('http') ? route : `${baseURL}${route}`, {
    waitUntil: 'networkidle',
  })
  await page.evaluate(() => document.fonts.ready)
  await page.screenshot({ path: `${outputDir}/${name}.png`, fullPage: true })

  const metrics = await page.evaluate(() => ({
    url: location.pathname,
    title: document.title,
    width: document.documentElement.clientWidth,
    scrollWidth: document.documentElement.scrollWidth,
    height: document.documentElement.scrollHeight,
    bodyHeight: document.body.scrollHeight,
    headerHeight: document.querySelector('header')?.getBoundingClientRect().height ?? null,
    footerHeight: document.querySelector('footer')?.getBoundingClientRect().height ?? null,
    h1: document.querySelector('h1')?.textContent?.trim() ?? null,
    h1Box: document.querySelector('h1')?.getBoundingClientRect().toJSON() ?? null,
  }))
  results.push({
    name,
    requestedRoute: route,
    status: response?.status() ?? null,
    ...metrics,
    errors: errors.slice(beforeErrors),
  })
}

await writeFile(`${outputDir}/metrics.json`, `${JSON.stringify(results, null, 2)}\n`)
console.log(JSON.stringify(results, null, 2))
await browser.close()
