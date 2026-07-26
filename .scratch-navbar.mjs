import { chromium } from 'playwright';

const browser = await chromium.launch({ executablePath: '/usr/bin/chromium' });
const page = await browser.newPage();
const errors = [];
page.on('pageerror', (e) => errors.push('pageerror: ' + e.message));
page.on('console', (msg) => { if (msg.type() === 'error') errors.push('console: ' + msg.text()); });
page.on('requestfailed', (req) => errors.push('requestfailed: ' + req.url() + ' — ' + req.failure()?.errorText));
page.on('response', (res) => { if (res.status() === 404) console.log('404 resource:', res.url()); });

await page.goto('http://127.0.0.1:8000/en', { waitUntil: 'networkidle' });

const links = await page.$$eval('header a', (els) =>
  els.map((el) => ({ text: el.textContent.trim(), href: el.getAttribute('href') })),
);
console.log('header links found:', JSON.stringify(links, null, 2));

// Try clicking the "Work" link specifically
const workLink = page.locator('header a', { hasText: 'Work' }).first();
const count = await workLink.count();
console.log('Work link count:', count);

if (count > 0) {
  const box = await workLink.boundingBox();
  console.log('Work link bounding box:', box);

  // check what element is actually at that point (z-index/overlap check)
  if (box) {
    const elAtPoint = await page.evaluate(([x, y]) => {
      const el = document.elementFromPoint(x, y);
      return el ? el.outerHTML.slice(0, 200) : null;
    }, [box.x + box.width / 2, box.y + box.height / 2]);
    console.log('element at click point:', elAtPoint);
  }

  await workLink.click({ timeout: 5000 }).catch((e) => console.log('click failed:', e.message));
  await page.waitForTimeout(1500);
  console.log('URL after click:', page.url());
}

console.log('errors:', errors.length ? errors : 'none');

await browser.close();
