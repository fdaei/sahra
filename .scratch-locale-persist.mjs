import { chromium } from 'playwright';

const browser = await chromium.launch({ executablePath: '/usr/bin/chromium' });
const context = await browser.newContext();
const page = await context.newPage();

// 1. Visit English about page.
await page.goto('http://localhost:8000/en/about', { waitUntil: 'networkidle' });
console.log('1. loaded:', page.url());

// 2. Switch to Persian via the language switcher (full navigation, as coded).
await page.click('summary[aria-label]');
await page.waitForTimeout(300);
const faOption = page.locator('li button', { hasText: 'فارسی' }).first();
const optCount = await faOption.count();
console.log('fa option found:', optCount);
if (optCount > 0) {
  await Promise.all([
    page.waitForNavigation({ waitUntil: 'networkidle' }),
    faOption.click(),
  ]);
}
console.log('2. after switch:', page.url());

const cookies = await context.cookies();
console.log('cookies:', cookies.map((c) => c.name));

// 3. Now visit a BARE path with no locale prefix — should redirect to /fa/... if persisted.
await page.goto('http://localhost:8000/contact', { waitUntil: 'networkidle' });
console.log('3. bare /contact redirected to:', page.url());

// 4. Also check the bare root.
await page.goto('http://localhost:8000/', { waitUntil: 'networkidle' });
console.log('4. bare / redirected to:', page.url());

await browser.close();
