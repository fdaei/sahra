import { chromium } from 'playwright'

const browser = await chromium.launch()
const page = await browser.newPage({ viewport: { width: 1440, height: 1000 } })
await page.goto('http://127.0.0.1:8000/en', { waitUntil: 'networkidle' })
await page.waitForTimeout(500)
const info = await page.evaluate(() => {
  const stage = document.querySelector('.orbit-stage').getBoundingClientRect()
  const one = (sel) => {
    const e = document.querySelector(sel)
    if (!e) return null
    const r = e.getBoundingClientRect()
    return {
      left: +(r.left - stage.left).toFixed(1),
      width: +r.width.toFixed(1),
      centre: +(r.left - stage.left + r.width / 2).toFixed(1),
      top: +(r.top - stage.top).toFixed(1),
    }
  }
  return {
    stageWidth: +stage.width.toFixed(1),
    social: one('.service-pill--social'),
    branding: one('.service-pill--branding'),
    content: one('.service-pill--content'),
    design: one('.service-pill--design'),
    core: one('.orbit-core'),
  }
})
console.log(JSON.stringify(info, null, 1))
await browser.close()
