import { usePage } from '@inertiajs/vue3'
import type { App } from 'vue'
import type { SharedProps } from '@/types'

/**
 * Thin bridge to Laravel's translation files.
 *
 * Laravel's `lang/{locale}/*.php` files are compiled into the page props by
 * App\Providers\AppServiceProvider (Inertia::share('translations')), so the
 * frontend reads exactly the same strings as Blade and validation messages.
 *
 * Usage:
 *   const { t } = useTranslations()
 *   t('common.read_more')
 *   t('validation.required', { attribute: 'email' })
 *   t('blog.reading_time', { minutes: 5 })
 */

type Replacements = Record<string, string | number>

function resolve(
  translations: Record<string, unknown>,
  key: string,
): string | undefined {
  const value = key
    .split('.')
    .reduce<unknown>(
      (carry, segment) =>
        carry && typeof carry === 'object'
          ? (carry as Record<string, unknown>)[segment]
          : undefined,
      translations,
    )

  return typeof value === 'string' ? value : undefined
}

function interpolate(line: string, replacements: Replacements): string {
  return Object.entries(replacements).reduce(
    (carry, [token, value]) =>
      carry
        .replace(new RegExp(`:${token}\\b`, 'g'), String(value))
        .replace(new RegExp(`\\{${token}\\}`, 'g'), String(value)),
    line,
  )
}

export function useTranslations() {
  const page = usePage<SharedProps & { translations: Record<string, unknown> }>()

  function t(key: string, replacements: Replacements = {}): string {
    const line = resolve(page.props.translations ?? {}, key)

    // Missing key: return the key itself so the gap is visible rather than
    // rendering an empty string that looks like a layout bug.
    if (line === undefined) {
      if (import.meta.env.DEV) {
        console.warn(`[i18n] Missing translation: ${key}`)
      }
      return key
    }

    return interpolate(line, replacements)
  }

  /** Pick "singular|plural" based on count. */
  function tChoice(key: string, count: number, replacements: Replacements = {}): string {
    const line = t(key, { ...replacements, count })
    const [singular, plural] = line.split('|')

    return count === 1 ? singular : (plural ?? singular)
  }

  return { t, tChoice }
}

/** Global `$t` so templates can call it without importing. */
export function installTranslations(app: App): void {
  app.config.globalProperties.$t = (key: string, replacements: Replacements = {}) => {
    const { t } = useTranslations()
    return t(key, replacements)
  }
}

declare module 'vue' {
  interface ComponentCustomProperties {
    $t: (key: string, replacements?: Replacements) => string
  }
}
