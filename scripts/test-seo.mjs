const base = process.env.BASE_URL ?? 'http://127.0.0.1:8000'
const paths = ['/en', '/en/about', '/fa', '/ar']
for (const path of paths) {
  const response = await fetch(new URL(path, base))
  const html = await response.text()
  const checks = {
    status: response.status === 200,
    title: /<title[^>]*>[^<]+<\/title>/i.test(html),
    description: /<meta[^>]+name=["']description["'][^>]+content=["'][^"']+/i.test(html),
    canonical: /<link[^>]+rel=["']canonical["'][^>]+href=["'][^"']+/i.test(html),
    h1: /<h1\b/i.test(html),
    content: html.length > 5000,
  }
  if (!Object.values(checks).every(Boolean)) {
    console.error(path, checks, `(${html.length} bytes)`)
    process.exitCode = 1
  } else console.log(`PASS ${path}`)
}
