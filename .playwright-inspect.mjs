import { chromium } from '@playwright/test';
import fs from 'fs';

const OUT = '/tmp/claude-1000/-home-fdaei-workspace-sahra/61acd396-9dd1-42df-8f1a-daa56ee0600b/scratchpad/own-site';
fs.mkdirSync(OUT, { recursive: true });

const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1600, height: 1000 } });

const consoleMsgs = [];
page.on('console', (msg) => consoleMsgs.push(`[${msg.type()}] ${msg.text()}`));
page.on('pageerror', (err) => consoleMsgs.push(`[pageerror] ${err}`));
page.on('requestfailed', (req) => consoleMsgs.push(`[requestfailed] ${req.url()} ${req.failure()?.errorText}`));

await page.goto('http://127.0.0.1:8123/en', { waitUntil: 'load', timeout: 30000 });
await page.waitForTimeout(2000);

fs.writeFileSync(`${OUT}/console.log`, consoleMsgs.join('\n'));
await page.screenshot({ path: `${OUT}/home-load.png`, fullPage: false });

const bodyHtmlLen = await page.evaluate(() => document.getElementById('app')?.innerHTML.length ?? -1);
fs.writeFileSync(`${OUT}/app-html-len.txt`, String(bodyHtmlLen));

await browser.close();
