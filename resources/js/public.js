import.meta.glob([
  '../images/decor/arc-rings.svg',
  '../images/decor/arc-rings-{project,service-l,service-r}.svg',
  '../images/decor/dune-contours.webp',
])

function initAnalytics() {
  const { gtmId, gaId } = document.body.dataset
  const hotjarId = document.body.dataset.hotjarId?.trim()
  const hasHotjar = /^[a-zA-Z0-9]+$/.test(hotjarId ?? '')
  if (!gtmId && !gaId && !hasHotjar) return

  window.dataLayer ??= []
  if (gtmId) window.dataLayer.push({ 'gtm.start': Date.now(), event: 'gtm.js' })
  if (gaId) {
    window.gtag = function () { window.dataLayer.push(arguments) }
    window.gtag('js', new Date())
    window.gtag('config', gaId)
  }

  const addScript = src => {
    const script = document.createElement('script')
    script.async = true
    script.src = src
    document.head.append(script)
  }
  const load = () => {
    if (gtmId) addScript('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(gtmId))
    if (gaId) addScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(gaId))
    if (hasHotjar) {
      if (/^\d+$/.test(hotjarId)) {
        window.hj = window.hj || function () { (window.hj.q ||= []).push(arguments) }
        window._hjSettings = { hjid: Number(hotjarId), hjsv: 6 }
        addScript('https://static.hotjar.com/c/hotjar-' + hotjarId + '.js?sv=6')
      } else {
        addScript('https://t.contentsquare.net/uxa/' + hotjarId + '.js')
      }
    }
  }

  const interactions = new AbortController()
  let scheduled = false
  let timer
  const schedule = () => {
    if (scheduled) return
    scheduled = true
    clearTimeout(timer)
    interactions.abort()
    if ('requestIdleCallback' in window) window.requestIdleCallback(load, { timeout: 1500 })
    else window.setTimeout(load, 0)
  }
  const afterLoad = () => {
    if (!scheduled) timer = window.setTimeout(schedule, 2400)
  }

  for (const event of ['pointerdown', 'keydown']) {
    window.addEventListener(event, schedule, { passive: true, signal: interactions.signal })
  }
  if (document.readyState === 'complete') afterLoad()
  else window.addEventListener('load', afterLoad, { once: true })
}

function initNavigation() {
  const menu = document.getElementById('mobile-menu')
  const opener = document.querySelector('[data-action="openMenu"]')
  if (menu && opener) {
    opener.addEventListener('click', () => {
      menu.showModal()
      opener.setAttribute('aria-expanded', 'true')
    })
    menu.addEventListener('click', event => {
      if (event.target === menu || event.target.closest('[data-action="closeMenu"]')) {
        menu.close()
      }
    })
    menu.addEventListener('close', () => opener.setAttribute('aria-expanded', 'false'))
    const desktop = matchMedia('(min-width: 1024px)')
    desktop.addEventListener('change', () => {
      if (desktop.matches && menu.open) menu.close()
    })
  }

  for (const trigger of document.querySelectorAll('[data-disclosure]')) {
    const panel = document.getElementById(trigger.getAttribute('aria-controls'))
    trigger.addEventListener('click', () => {
      panel.hidden = !panel.hidden
      trigger.setAttribute('aria-expanded', String(!panel.hidden))
    })
  }

  for (const root of document.querySelectorAll('[data-nav-dropdown]')) {
    const trigger = root.querySelector('button[aria-controls]')
    const panel = document.getElementById(trigger.getAttribute('aria-controls'))
    let timer
    const setOpen = open => {
      clearTimeout(timer)
      panel.hidden = !open
      trigger.setAttribute('aria-expanded', String(open))
    }
    trigger.addEventListener('click', () => setOpen(panel.hidden))
    root.addEventListener('pointerenter', event => {
      if (event.pointerType === 'mouse') setOpen(true)
    })
    root.addEventListener('pointerleave', event => {
      if (event.pointerType === 'mouse') timer = setTimeout(() => setOpen(false), 150)
    })
    root.addEventListener('focusout', event => {
      if (!root.contains(event.relatedTarget)) setOpen(false)
    })
    root.addEventListener('keydown', event => {
      if (event.key === 'Escape' && !panel.hidden) {
        setOpen(false)
        trigger.focus()
      }
      if (event.key === 'ArrowDown' && event.target === trigger) {
        event.preventDefault()
        setOpen(true)
        panel.querySelector('a')?.focus()
      }
    })
  }

  const languagePickers = document.querySelectorAll('details.language-switcher')
  document.addEventListener('click', event => {
    for (const picker of languagePickers) {
      if (!picker.contains(event.target)) picker.open = false
    }
  })
  for (const picker of languagePickers) {
    picker.addEventListener('keydown', event => {
      if (event.key !== 'Escape' || !picker.open) return
      picker.open = false
      picker.querySelector('summary').focus()
    })
  }
}

function initDialogs() {
  for (const panel of document.querySelectorAll('[data-modal-panel]')) {
    const dialog = document.createElement('dialog')
    dialog.className = 'public-modal'
    dialog.setAttribute('aria-labelledby', panel.getAttribute('aria-labelledby'))
    const close = panel.querySelector('[data-close-modal]')
    close.hidden = false
    panel.before(dialog)
    dialog.append(panel)
    panel.classList.add('!p-0')

    close.addEventListener('click', () => dialog.close())
    dialog.addEventListener('click', event => {
      if (event.target !== dialog) return
      const bounds = dialog.getBoundingClientRect()
      if (event.clientX < bounds.left || event.clientX > bounds.right ||
          event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close()
    })

    for (const opener of document.querySelectorAll('[data-open-modal]')) {
      if (opener.hash !== '#' + panel.id) continue
      opener.addEventListener('click', event => {
        if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return
        event.preventDefault()
        if (!dialog.open) dialog.showModal()
      })
    }
    if (panel.hasAttribute('data-show-modal') || location.hash === '#' + panel.id) {
      dialog.showModal()
      panel.querySelector('[data-download-ready]')?.click()
    }
  }
}

function initServicePicker() {
  const picker = document.querySelector('[data-service-picker]')
  if (!picker) return

  const search = picker.querySelector('[data-service-search]')
  const options = [...picker.querySelectorAll('[data-service-option]')]
  const label = picker.querySelector('[data-selected-services]')
  const empty = picker.querySelector('[data-services-empty]')
  const filter = () => {
    const query = search.value.trim().toLocaleLowerCase()
    for (const option of options) option.hidden = !option.textContent.toLocaleLowerCase().includes(query)
    empty.hidden = options.some(option => !option.hidden)
  }

  search.addEventListener('input', filter)
  picker.addEventListener('change', () => {
    label.textContent = options
      .filter(option => option.querySelector('input').checked)
      .map(option => option.querySelector('span').textContent.trim())
      .join(', ') || label.dataset.selectedServices
  })
  picker.addEventListener('toggle', () => {
    if (picker.open) {
      search.focus()
    } else {
      search.value = ''
      filter()
    }
  })
  document.addEventListener('click', event => {
    if (!picker.contains(event.target)) picker.open = false
  })
  picker.addEventListener('keydown', event => {
    if (event.key !== 'Escape') return
    picker.open = false
    picker.querySelector('summary').focus()
  })
}

function setDot(dot, active) {
  if (active) dot.setAttribute('aria-current', 'true')
  else dot.removeAttribute('aria-current')
}

function initProjects() {
  const section = document.querySelector('[data-project-showcase]')
  if (!section) return

  const rows = [...section.querySelectorAll('[data-project-row]')]
  const desktopPanels = [...section.querySelectorAll('[data-desktop-project]')]
  const desktopDots = [...section.querySelectorAll('[data-action="selectDesktopProject"]')]
  const mobile = section.querySelector('[data-project-mobile]')
  const mobilePanels = [...section.querySelectorAll('[data-mobile-project]')]
  const mobileDots = [...section.querySelectorAll('[data-action="selectMobileProject"]')]
  let selectedDesktop = 0
  let selectedMobile = 0
  const showDesktop = index => {
    if (!rows[index]) return
    selectedDesktop = index
    rows.forEach((row, position) => {
      const active = position === index
      const tab = row.querySelector('[role=tab]')
      row.parentElement.classList.toggle('is-active', active)
      tab.setAttribute('aria-selected', String(active))
      tab.tabIndex = active ? 0 : -1
      row.querySelectorAll('[data-active-project-link]').forEach(link => { link.hidden = !active })
      row.querySelector('.project-slide-details').setAttribute('aria-hidden', String(!active))
      desktopPanels[position].hidden = !active
      if (desktopDots[position]) setDot(desktopDots[position], active)
    })
  }
  const showMobile = index => {
    selectedMobile = (index + mobilePanels.length) % mobilePanels.length
    mobilePanels.forEach((panel, position) => { panel.hidden = position !== selectedMobile })
    mobileDots.forEach((dot, position) => setDot(dot, position === selectedMobile))
  }

  rows.forEach((row, index) => {
    const tab = row.querySelector('[role=tab]')
    row.addEventListener('pointerenter', event => {
      if (event.pointerType === 'mouse') showDesktop(index)
    })
    row.querySelectorAll('[data-action="selectProject"]').forEach(button => {
      button.addEventListener('click', () => showDesktop(index))
    })
    tab.addEventListener('focus', () => showDesktop(index))
    tab.addEventListener('keydown', event => {
      const next = nextTab(event.key, index, rows.length)
      if (next === null) return
      event.preventDefault()
      rows[next].querySelector('[role=tab]').focus()
    })
  })
  desktopDots.forEach((dot, index) => dot.addEventListener('click', () => showDesktop(index)))
  mobileDots.forEach((dot, index) => dot.addEventListener('click', () => showMobile(index)))

  if (mobile && mobilePanels.length > 1) {
    let startX = null
    let swiped = false
    mobile.addEventListener('pointerdown', event => {
      startX = event.clientX
      swiped = false
    })
    mobile.addEventListener('pointercancel', () => { startX = null })
    mobile.addEventListener('pointerup', event => {
      if (startX === null) return
      const distance = event.clientX - startX
      startX = null
      if (Math.abs(distance) < 40) return
      swiped = true
      showMobile(selectedMobile + Math.sign(-distance) * (document.dir === 'rtl' ? -1 : 1))
    })
    mobile.addEventListener('click', event => {
      if (swiped) event.preventDefault()
      swiped = false
    }, true)
  }

  if (rows.length > 1 && !reduceMotion.matches) {
    setInterval(() => {
      if (document.hidden || section.matches(':hover, :focus-within') || !rows[0].offsetWidth) return
      const bounds = section.getBoundingClientRect()
      if (bounds.bottom > 0 && bounds.top < innerHeight) showDesktop((selectedDesktop + 1) % rows.length)
    }, 6000)
  }
}

function nextTab(key, index, total) {
  if (key === 'Home') return 0
  if (key === 'End') return total - 1
  const forward = document.dir === 'rtl' ? 'ArrowLeft' : 'ArrowRight'
  const backward = document.dir === 'rtl' ? 'ArrowRight' : 'ArrowLeft'
  if (key === forward || key === 'ArrowDown') return (index + 1) % total
  if (key === backward || key === 'ArrowUp') return (index + total - 1) % total
  return null
}

function initShowcaseTabs() {
  const tabs = [...document.querySelectorAll('[data-action="selectShowcase"]')]
  const selectedStyle = ['font-medium', 'text-ink', 'underline', 'decoration-from-font', 'underline-offset-2']
  function select(index) {
    tabs.forEach((tab, position) => {
      const active = position === index
      tab.tabIndex = active ? 0 : -1
      tab.setAttribute('aria-selected', String(active))
      selectedStyle.forEach(className => tab.classList.toggle(className, active))
      document.getElementById(tab.getAttribute('aria-controls')).hidden = !active
    })
  }
  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => select(index))
    tab.addEventListener('keydown', event => {
      const next = nextTab(event.key, index, tabs.length)
      if (next === null) return
      event.preventDefault()
      select(next)
      tabs[next].focus()
    })
  })
}

function initMoreCards(action, selector, limit, step, mobileOnly = false) {
  const button = document.querySelector('[data-action="' + action + '"]')
  if (!button) return

  const cards = [...document.querySelectorAll(selector)]
  const mobile = matchMedia('(max-width: 639px)')
  let visible = limit
  const refresh = () => {
    const count = mobile.matches ? visible : mobileOnly ? cards.length : Math.max(6, visible)
    cards.forEach((card, index) => { card.hidden = index >= count })
    button.hidden = cards.length <= count
  }
  button.addEventListener('click', () => {
    visible = Math.max(visible, (!mobile.matches && !mobileOnly) ? 6 : 0) + step
    refresh()
  })
  mobile.addEventListener('change', refresh)
  refresh()
}

function initTestimonials() {
  const rail = document.querySelector('[data-ref="testimonialRail"]')
  if (!rail) return
  const cards = [...rail.children]
  const dots = [...document.querySelectorAll('[data-action="goToTestimonial"]')]
  if (cards.length < 2) return
  const step = () => Math.abs(cards[1].offsetLeft - cards[0].offsetLeft)
  let active = 0
  let direction = 1
  let pausedUntil = 0
  const go = index => rail.scrollTo({
    left: (getComputedStyle(rail).direction === 'rtl' ? -1 : 1) * index * step(),
    behavior: reduceMotion.matches ? 'auto' : 'smooth',
  })
  rail.addEventListener('scroll', () => {
    active = Math.min(cards.length - 1, Math.round(Math.abs(rail.scrollLeft) / (step() || 1)))
    dots.forEach((dot, index) => setDot(dot, index === active))
  }, { passive: true })
  rail.addEventListener('pointerdown', () => { pausedUntil = Date.now() + 8000 }, { passive: true })
  dots.forEach((dot, index) => dot.addEventListener('click', () => {
    pausedUntil = Date.now() + 8000
    go(index)
  }))
  if (!reduceMotion.matches) {
    setInterval(() => {
      if (document.hidden || !rail.offsetWidth || Date.now() < pausedUntil || rail.matches(':hover, :focus-within')) return
      if (active + direction < 0 || active + direction >= cards.length) direction *= -1
      go(active + direction)
    }, 5000)
  }
}

function initTeamRail() {
  const rail = document.querySelector('[data-team-rail]')
  if (!rail) return

  let drag = null
  rail.addEventListener('pointerdown', event => {
    if (event.pointerType !== 'mouse' || event.button !== 0) return
    drag = { pointer: event.pointerId, x: event.clientX, scroll: rail.scrollLeft }
    rail.setPointerCapture(event.pointerId)
    event.preventDefault()
  })
  rail.addEventListener('pointermove', event => {
    if (drag?.pointer !== event.pointerId) return
    rail.scrollLeft = drag.scroll - (event.clientX - drag.x)
  })
  rail.addEventListener('lostpointercapture', () => { drag = null })

  if (reduceMotion.matches || !('IntersectionObserver' in window)) return

  let frame
  let direction = 1
  let previousTime
  let position
  const animate = time => {
    if (!document.hidden && !rail.matches(':hover, :focus-within, :active')) {
      const limit = rail.scrollWidth - rail.clientWidth
      if (limit > 0) {
        position = Math.max(0, Math.min(limit, position + direction * Math.min(time - previousTime, 50) * 0.021))
        if (position === 0) direction = 1
        if (position === limit) direction = -1
        rail.scrollLeft = position
      }
    } else {
      position = rail.scrollLeft
    }
    previousTime = time
    frame = requestAnimationFrame(animate)
  }
  const observer = new IntersectionObserver(([entry]) => {
    cancelAnimationFrame(frame)
    if (!entry.isIntersecting || reduceMotion.matches) return
    previousTime = performance.now()
    position = rail.scrollLeft
    frame = requestAnimationFrame(animate)
  })
  observer.observe(rail)
}

function initCopyButtons() {
  if (!navigator.clipboard) return
  for (const button of document.querySelectorAll('[data-action="copyLink"]')) {
    button.hidden = false
    const label = button.getAttribute('aria-label')
    let timer
    button.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(location.href)
        button.setAttribute('aria-label', button.dataset.copiedLabel)
        button.title = button.dataset.copiedLabel
        clearTimeout(timer)
        timer = setTimeout(() => {
          button.setAttribute('aria-label', label)
          button.removeAttribute('title')
        }, 2000)
      } catch {
        // The adjacent social links remain available if clipboard access is denied.
      }
    })
  }
}

const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)')
initAnalytics()
initNavigation()
initDialogs()
initServicePicker()
initProjects()
initShowcaseTabs()
initMoreCards('loadMore', '[data-work-card]', 4, 6)
initMoreCards('showMoreInsights', '[data-insight-card]', 2, 3, true)
initTestimonials()
initTeamRail()
initCopyButtons()

if (!reduceMotion.matches && 'IntersectionObserver' in window) {
  const observer = new IntersectionObserver(entries => {
    for (const entry of entries) {
      if (!entry.isIntersecting) continue
      entry.target.animate(
        [{ opacity: 0.45, transform: 'translateY(12px)' }, { opacity: 1, transform: 'none' }],
        { duration: 360, easing: 'ease-out' },
      )
      observer.unobserve(entry.target)
    }
  }, { threshold: 0.1 })
  document.querySelectorAll('[data-reveal]').forEach(element => {
    if (element.getBoundingClientRect().top > innerHeight) observer.observe(element)
  })
}
