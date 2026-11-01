import { test, expect } from '@playwright/test'

// Run only against the isolated database made by create-seo-fixture.php.
for (const javaScriptEnabled of [false, true]) {
  test.describe(`PHP HTML; JavaScript ${javaScriptEnabled ? 'on' : 'off'}`, () => {
    test.use({ javaScriptEnabled })
    test('all public page types have readable initial content', async ({ page }) => {
      const errors: string[] = []
      page.on('pageerror', error => errors.push(error.message))
      page.on('console', message => { if (/hydration|mismatch/i.test(message.text())) errors.push(message.text()) })
      for (const path of ['/en', '/en/about', '/en/services', '/en/contact', '/en/work', '/en/insights', '/en/privacy-policy', '/en/terms']) {
        const response = await page.goto(path)
        expect(response?.status()).toBe(200)
        await expect(page.locator('main h1')).toHaveCount(1)
        await expect(page.locator('main h1')).not.toBeEmpty()
        await expect(page.locator('head title')).toHaveCount(1)
        await expect(page.locator('link[rel=canonical]')).toHaveCount(1)
        expect((await page.locator('main').innerText()).length).toBeGreaterThan(100)
        if (javaScriptEnabled) await expect(page.locator('#app')).toHaveAttribute('data-v-app', '')
      }
      await page.goto('/en/work')
      const project = await page.locator('main a[href*="/en/work/"]').first().getAttribute('href')
      expect(project).toBeTruthy()
      expect((await page.goto(project!))?.status()).toBe(200)
      await expect(page.locator('main h1')).not.toBeEmpty()
      await page.goto('/en/insights/seo-visible')
      await expect(page.locator('main')).toContainText('Final article paragraph for SEO verification.')
      await expect(page.locator('main')).not.toContainText('Secret unpublished body')
      await expect(page.locator('h1')).toHaveCount(1)
      expect((await page.goto('/en/insights/seo-draft'))?.status()).toBe(404)
      await expect(page.locator('meta[name=robots]')).toHaveAttribute('content', 'noindex, follow')
      await page.goto('/fa/insights/seo-farsi')
      await expect(page.locator('html')).toHaveAttribute('lang', 'fa')
      await expect(page.locator('html')).toHaveAttribute('dir', 'rtl')
      await expect(page.locator('main')).toContainText('متن کامل مقاله فارسی')
      expect(errors).toEqual([])
    })

    test('the bare domain opens English in a Persian browser and after selecting Persian', async ({ page }) => {
      await page.setExtraHTTPHeaders({ 'Accept-Language': 'fa-IR,fa;q=0.9,en;q=0.8' })
      await page.goto('/')
      await expect(page).toHaveURL(/\/en$/)
      await expect(page.locator('html')).toHaveAttribute('lang', 'en')

      await page.goto('/fa')
      await expect(page.locator('html')).toHaveAttribute('lang', 'fa')
      const redirect = await page.request.get('/', { maxRedirects: 0, headers: { 'Accept-Language': 'fa-IR' } })
      expect(redirect.status()).toBe(301)
      expect(redirect.headers().location).toMatch(/\/en$/)

      await page.goto('/')
      await expect(page).toHaveURL(/\/en$/)
      await expect(page.locator('html')).toHaveAttribute('lang', 'en')
      await expect(page.locator('link[hreflang="x-default"]')).toHaveAttribute('href', /\/en$/)
    })
  })
}

test('Inertia navigation updates the whole head without duplicate or stale tags', async ({ page }) => {
  const errors: string[] = []
  page.on('pageerror', error => errors.push(error.message))
  await page.goto('/en/insights')
  await expect(page.locator('#app')).toHaveAttribute('data-v-app', '')
  await page.evaluate(() => { (window as unknown as Record<string, unknown>).seoNavigationMarker = 'same-document' })
  await page.locator('main a[href="/en/insights/seo-visible"]').first().click()
  await expect(page).toHaveURL(/\/en\/insights\/seo-visible$/)
  await expect(page).toHaveTitle('SEO visible article')
  await expect(page.locator('main')).toContainText('Final article paragraph for SEO verification.')
  expect(await page.evaluate(() => (window as unknown as Record<string, unknown>).seoNavigationMarker)).toBe('same-document')
  await expect(page.locator('title')).toHaveCount(1)
  await expect(page.locator('meta[name=description]')).toHaveCount(1)
  await expect(page.locator('link[rel=canonical]')).toHaveCount(1)
  await expect(page.locator('link[rel=canonical]')).toHaveAttribute('href', /\/en\/insights\/seo-visible$/)
  await expect(page.locator('link[hreflang=fa]')).toHaveAttribute('href', /\/fa\/insights\/seo-farsi$/)
  await expect(page.locator('meta[property="og:type"]')).toHaveAttribute('content', 'article')
  expect(await page.locator('script[type="application/ld+json"]').evaluateAll(nodes => nodes.map(node => JSON.parse(node.textContent ?? '{}')['@type']))).toContain('Article')
  await page.goBack()
  await expect(page).toHaveURL(/\/en\/insights$/)
  await expect(page.locator('meta[property="og:type"]')).toHaveAttribute('content', 'website')
  await expect(page.locator('link[hreflang=fa]')).toHaveAttribute('href', /\/fa\/insights$/)
  await expect(page.locator('meta[property="article:published_time"]')).toHaveCount(0)
  expect(await page.locator('script[type="application/ld+json"]').evaluateAll(nodes => nodes.map(node => JSON.parse(node.textContent ?? '{}')['@type']))).not.toContain('Article')
  await expect(page.locator('main')).toHaveCount(1)
  expect(errors).toEqual([])
})

test.describe('Page navigation scroll', () => {
  // The regular-motion setting catches document-wide smooth scrolling;
  // reduced motion disables it and would hide this regression.
  test.use({ reducedMotion: 'no-preference' })

  test('a page opened from a footer link starts at the top immediately', async ({ page }) => {
    await page.goto('/en/insights')
    await expect(page.locator('#app')).toHaveAttribute('data-v-app', '')
    const previousHeading = await page.locator('main h1').innerText()
    const link = page.locator('footer a[href="/en/services"]').first()
    await link.scrollIntoViewIfNeeded()
    expect(await page.evaluate(() => window.scrollY)).toBeGreaterThan(500)
    await page.evaluate(() => {
      document.addEventListener('inertia:navigate', () => {
        (window as unknown as Record<string, unknown>).scrollAtNavigation = window.scrollY
      }, { once: true })
    })
    await link.click()
    await expect(page).toHaveURL(/\/en\/services$/)
    expect(await page.evaluate(() => (window as unknown as Record<string, unknown>).scrollAtNavigation)).toBe(0)
    await expect(page.locator('main h1')).not.toHaveText(previousHeading)
    await page.evaluate(() => new Promise<void>(resolve => {
      requestAnimationFrame(() => requestAnimationFrame(() => resolve()))
    }))
    expect(await page.evaluate(() => window.scrollY)).toBe(0)
  })

  test('browser back returns to the exact section of the previous page', async ({ page }) => {
    await page.goto('/en/insights')
    await expect(page.locator('#app')).toHaveAttribute('data-v-app', '')

    const link = page.locator('footer a[href="/en/services"]').first()
    await link.scrollIntoViewIfNeeded()
    const scrollBeforeVisit = await page.evaluate(() => window.scrollY)
    expect(scrollBeforeVisit).toBeGreaterThan(0)

    await link.click()
    await expect(page).toHaveURL(/\/en\/services$/)
    await page.goBack()
    await expect(page).toHaveURL(/\/en\/insights$/)

    await expect.poll(() => page.evaluate(() => window.scrollY)).toBe(scrollBeforeVisit)
  })
})
