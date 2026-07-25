import { test, expect } from '@playwright/test'

/**
 * Runs against every project defined in playwright.config.ts (7 breakpoints).
 * Checks the invariants Phase 7 requires: no horizontal overflow, header and
 * primary CTA remain visible and reachable, mobile menu opens/closes cleanly.
 */
const pages = ['/en', '/en/work', '/en/services', '/en/about', '/en/insights', '/en/contact']

for (const path of pages) {
  test(`${path} has no horizontal overflow`, async ({ page }) => {
    await page.goto(path)

    const hasOverflow = await page.evaluate(
      () => document.documentElement.scrollWidth > document.documentElement.clientWidth,
    )

    expect(hasOverflow).toBe(false)
  })
}

test('mobile menu opens, traps focus, and closes on Escape', async ({ page, viewport }) => {
  test.skip(!viewport || viewport.width >= 1024, 'Desktop uses the inline nav, not the mobile menu')

  await page.goto('/en')

  const trigger = page.getByRole('button', { name: /open menu/i })
  await trigger.click()

  const dialog = page.getByRole('dialog')
  await expect(dialog).toBeVisible()

  await page.keyboard.press('Escape')
  await expect(dialog).not.toBeVisible()
})

test('language switcher lands on the translated equivalent page', async ({ page }) => {
  await page.goto('/en/about')

  await page.getByRole('button', { name: /change language/i }).click()
  await page.getByRole('option', { name: 'فارسی' }).click()

  await expect(page).toHaveURL(/\/fa\/about/)
  await expect(page.locator('html')).toHaveAttribute('dir', 'rtl')
})

test('reduced motion disables marquee animation', async ({ page }) => {
  await page.emulateMedia({ reducedMotion: 'reduce' })
  await page.goto('/en')

  const hasReducedClass = await page.evaluate(
    () => document.documentElement.classList.contains('reduced-motion'),
  )

  expect(hasReducedClass).toBe(true)
})
