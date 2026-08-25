# Graph Report - sahra  (2026-08-20)

## Corpus Check
- 360 files · ~2,220,537 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 4925 nodes · 12533 edges · 233 communities (188 shown, 45 thin omitted)
- Extraction: 91% EXTRACTED · 9% INFERRED · 0% AMBIGUOUS · INFERRED: 1183 edges (avg confidence: 0.68)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `33379fd9`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- components/chart.js
- rich-editor.js
- stat/chart.js
- draw
- ce
- updateElements
- getLength
- _update
- constructor
- Illuminate\Database\Eloquent\Model
- BasePolicy
- Redirect
- constructor
- file-upload.js
- ManageSettings
- Project
- x
- Post
- buildTicks
- deleteInDirection
- qt
- te
- Filament\Resources\Pages\ListRecords
- select.js
- ContactSubmissionRequest
- St
- support.js
- markdown-editor.js
- Illuminate\Database\Eloquent\Builder
- ec
- D
- HandlesTranslations.php
- draw
- getContext
- notifications.js
- _notify
- P
- PageSection
- moveCursorInDirection
- setAttribute
- AppHeader.vue
- get
- getLocationRange
- Figma ↔ Code Fidelity Audit — SahraMarketing
- _update
- compilerOptions
- LeadMagnet.vue
- Vn
- wn
- Illuminate\Database\Eloquent\Factories\Factory
- getProps
- getDatasetMeta
- fn
- buildTicks
- Sahra — Final Figma Parity Verification
- determineDataLimits
- notifyEditorElement
- Error.vue
- echo.js
- preload
- getDatasetMeta
- AppFooter.vue
- m
- index.ts
- vue
- useMotion.ts
- Work/Show.vue
- SeoHead.vue
- devDependencies
- _notify
- A
- ViewContactSubmission
- AdminPanelProvider.php
- PostFactory
- T
- Illuminate\Console\Command
- ProjectFactory
- appendBlockForElement
- updateElements
- dependencies
- t
- color-picker.js
- render
- de
- Contact.vue
- Insights/Show.vue
- ProjectsShowcase.vue
- composer.json
- scripts
- scripts
- app.js
- r
- i
- AppServiceProvider
- require
- require-dev
- ServicesOrbit.vue
- useTranslations.ts
- He
- What You Must Do When Invoked
- oe
- le
- Figma Audit — SahraMarketing
- ProcessSection.vue
- config
- pe
- I
- User.php
- Be
- Asset Manifest
- te
- .scratch-mobile-figma-audit.mjs
- @inertiajs/vue3
- Architecture
- psr-4
- keywords
- Per-page breakdown
- graphify reference: extra exports and benchmark
- ClientPolicy
- Sahra Marketing
- 2026_07_27_000002_publish_home_packages.php
- ContactSubmissionPolicy
- Implementation Log
- .scratch-navbar.mjs
- package.json
- FaqPolicy
- postcss
- IndustryPolicy
- @tailwindcss/typography
- MenuPolicy
- eslint-plugin-vue
- NewsletterSubscriptionPolicy
- .scratch-locale-persist.mjs
- fetch-fonts.sh
- responsive.spec.ts
- PagePolicy
- graphify reference: query, path, explain
- PostCategoryPolicy
- Traceability Matrix
- graphify reference: add a URL and watch a folder
- graphify reference: commit hook and native CLAUDE.md integration
- graphify reference: incremental update and cluster-only
- Content TODO — real assets and copy still needed
- graphify reference: GitHub clone and cross-repo merge
- graphify reference: transcribe video and audio
- graphify
- extraction-spec.md
- PostPolicy
- PostTagPolicy
- ProjectPolicy
- RedirectPolicy
- ServicePolicy
- SocialLinkPolicy
- TeamMemberPolicy
- TestimonialPolicy
- prettier
- @playwright/test
- @tailwindcss/forms
- @types/node
- vue-tsc

## God Nodes (most connected - your core abstractions)
1. `_update()` - 88 edges
2. `_update()` - 84 edges
3. `x()` - 82 edges
4. `te()` - 73 edges
5. `V()` - 72 edges
6. `draw()` - 54 edges
7. `vd()` - 52 edges
8. `Ae()` - 48 edges
9. `draw()` - 46 edges
10. `ge()` - 44 edges

## Surprising Connections (you probably didn't know these)
- `downloadablePost()` --references--> `Post`  [EXTRACTED]
  tests/Feature/Forms/LeadMagnetDownloadTest.php → app/Models/Post.php
- `te()` --indirect_call--> `Pr()`  [INFERRED]
  public/js/filament/forms/components/markdown-editor.js → public/js/filament/filament/echo.js
- `getExtension()` --indirect_call--> `Ht()`  [INFERRED]
  public/js/filament/forms/components/file-upload.js → public/js/filament/forms/components/markdown-editor.js
- `_getTestState()` --indirect_call--> `Ht()`  [INFERRED]
  public/js/filament/forms/components/file-upload.js → public/js/filament/forms/components/markdown-editor.js
- `dt()` --indirect_call--> `Ht()`  [INFERRED]
  public/js/filament/forms/components/rich-editor.js → public/js/filament/forms/components/markdown-editor.js

## Import Cycles
- None detected.

## Communities (233 total, 45 thin omitted)

### Community 0 - "components/chart.js"
Cohesion: 0.01
Nodes (106): acquireContext(), afterDraw(), alpha(), beforeDatasetDraw(), beforeDatasetsDraw(), bh(), Br(), calculateCircumference() (+98 more)

### Community 1 - "rich-editor.js"
Cohesion: 0.02
Nodes (118): activateAttributeIfSupported(), appendStringToTextAtIndex(), applyBlockAttribute(), attachmentDidChangeUploadProgress(), attachmentIsManaged(), attributeChangedCallback(), canRedo(), canUndo() (+110 more)

### Community 2 - "stat/chart.js"
Cohesion: 0.02
Nodes (102): aa(), addControllers(), addPlugins(), addScales(), an(), aspectRatio(), beforeDatasetDraw(), beforeDatasetsDraw() (+94 more)

### Community 3 - "draw"
Cohesion: 0.05
Nodes (93): ad(), adjustHitBoxes(), ae(), af(), C(), calculateLabelRotation(), _calculatePadding(), _computeAngle() (+85 more)

### Community 4 - "ce"
Cohesion: 0.15
Nodes (24): Ac(), Cc(), ce(), cl(), Dc(), Do(), Ec(), el() (+16 more)

### Community 5 - "updateElements"
Cohesion: 0.05
Nodes (70): Ao(), applyStack(), ar(), as(), _calculateBarIndexPixels(), _calculateBarValuePixels(), calculateCircumference(), calculateLabelRotation() (+62 more)

### Community 6 - "getLength"
Cohesion: 0.03
Nodes (126): addAttribute(), addAttributeAtRange(), addAttributesAtRange(), addHTMLAttribute(), appendText(), applyBlockAttributeAtRange(), breakFormattedBlock(), canBeGroupedWith() (+118 more)

### Community 7 - "_update"
Cohesion: 0.04
Nodes (95): addBox(), afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate() (+87 more)

### Community 8 - "constructor"
Cohesion: 0.06
Nodes (46): beforeinput(), box(), canApplyToDocument(), compositionend(), compositionstart(), compositionupdate(), constructor(), elementDidMutate() (+38 more)

### Community 9 - "Illuminate\Database\Eloquent\Model"
Cohesion: 0.03
Nodes (49): getLabel(), options(), Industry, MenuItem, PostCategory, PostTag, ProjectImage, SectionItem (+41 more)

### Community 10 - "BasePolicy"
Cohesion: 0.17
Nodes (5): User, BasePolicy, UserPolicy, Illuminate\Auth\Access\HandlesAuthorization, Illuminate\Foundation\Auth\User

### Community 11 - "Redirect"
Cohesion: 0.15
Nodes (8): RedirectToLocalisedRoute, SetAdminLocale, SetLocale, Redirect, Carbon\Carbon, Closure, Illuminate\Foundation\Configuration\Middleware, Symfony\Component\HttpFoundation\Response

### Community 12 - "constructor"
Cohesion: 0.03
Nodes (88): Bi(), Bl(), cf(), chartOptionScopes(), clone(), constructor(), create(), describe() (+80 more)

### Community 13 - "file-upload.js"
Cohesion: 0.04
Nodes (68): e(), i(), l(), Ni(), o(), t(), u(), ba() (+60 more)

### Community 14 - "ManageSettings"
Cohesion: 0.05
Nodes (17): getLabel(), options(), ManageSettings, Tabs, Tabs, HandleInertiaRequests, Setting, SocialLink (+9 more)

### Community 15 - "Project"
Cohesion: 0.04
Nodes (12): SitemapController, Menu, Project, SectionType, MediaTransformer, NavigationBuilder, Numerals, Illuminate\Foundation\Testing\TestCase (+4 more)

### Community 16 - "x"
Cohesion: 0.11
Nodes (75): at(), B(), br(), Bt(), cd(), Cr(), Ct(), dd() (+67 more)

### Community 17 - "Post"
Cohesion: 0.04
Nodes (27): AboutController, AdminLocaleController, ContactController, Controller, HomeController, LeadMagnetDownloadController, LegalController, NewsletterController (+19 more)

### Community 18 - "buildTicks"
Cohesion: 0.07
Nodes (42): disabled(), afterAutoSkip(), beforeDraw(), Bi(), buildLookupTable(), buildTicks(), determineDataLimits(), diff() (+34 more)

### Community 19 - "deleteInDirection"
Cohesion: 0.03
Nodes (118): attachFiles(), attachmentManagerDidRequestRemovalOfAttachment(), backspace(), breaksOnReturn(), Ca(), canSetCurrentAttribute(), canSetCurrentBlockAttribute(), compositionControllerDidRequestRemovalOfAttachment() (+110 more)

### Community 20 - "qt"
Cohesion: 0.04
Nodes (71): Ac(), addEventListener(), an(), Au(), average(), ba(), beforeDraw(), bu() (+63 more)

### Community 21 - "te"
Cohesion: 0.05
Nodes (12): Bi(), bn(), Id(), ji(), kd(), on(), qi(), Ri() (+4 more)

### Community 22 - "Filament\Resources\Pages\ListRecords"
Cohesion: 0.05
Nodes (18): ListClients, ListContactSubmissions, ListFaqs, ListIndustries, ListMenus, ListNewsletterSubscriptions, ListPages, ListPostCategories (+10 more)

### Community 23 - "select.js"
Cohesion: 0.07
Nodes (68): [g](), [x](), Sg(), Be(), $c(), ca(), D(), E() (+60 more)

### Community 24 - "ContactSubmissionRequest"
Cohesion: 0.06
Nodes (13): getLabel(), options(), ContactSubmissionRequest, ContactSubmission, NewsletterSubscription, ContactSubmissionReceived, Illuminate\Bus\Queueable, Illuminate\Contracts\Queue\ShouldQueue (+5 more)

### Community 25 - "St"
Cohesion: 0.06
Nodes (45): alpha(), At(), be(), dataset(), ea(), en(), Fa(), fe() (+37 more)

### Community 26 - "support.js"
Cohesion: 0.05
Nodes (52): ai(), apply(), B(), co(), Cr(), $e(), es(), Et() (+44 more)

### Community 27 - "markdown-editor.js"
Cohesion: 0.04
Nodes (143): _a(), Aa(), Ae(), af(), ai(), al(), An(), ao() (+135 more)

### Community 28 - "Illuminate\Database\Eloquent\Builder"
Cohesion: 0.04
Nodes (31): Resource, ClientResource, ContactSubmissionResource, FaqResource, IndustryResource, MenuResource, NewsletterSubscriptionResource, PageResource (+23 more)

### Community 29 - "ec"
Cohesion: 0.15
Nodes (19): tl(), ac(), Ai(), ca(), ec(), Fc(), G(), getIndexAngle() (+11 more)

### Community 30 - "D"
Cohesion: 0.06
Nodes (46): Bt(), xo(), addEventListener(), bindEvents(), bindResponsiveEvents(), bindUserEvents(), buildOrUpdateScales(), cl() (+38 more)

### Community 31 - "HandlesTranslations.php"
Cohesion: 0.03
Nodes (40): handleRecordCreation(), handleRecordUpdate(), mutateFormDataBeforeCreate(), mutateFormDataBeforeFill(), mutateFormDataBeforeSave(), CreateClient, EditClient, EditContactSubmission (+32 more)

### Community 32 - "draw"
Cohesion: 0.08
Nodes (48): $h(), adjustHitBoxes(), afterDraw(), bc(), Bl(), clear(), _computeLabelArea(), _computeTitleHeight() (+40 more)

### Community 33 - "getContext"
Cohesion: 0.05
Nodes (56): Yn(), et(), _a(), acquireContext(), add(), al(), ba(), _cachedScopes() (+48 more)

### Community 34 - "notifications.js"
Cohesion: 0.06
Nodes (24): actions(), button(), constructor(), danger(), dispatch(), dispatchSelf(), dispatchTo(), duration() (+16 more)

### Community 35 - "_notify"
Cohesion: 0.17
Nodes (15): active(), _animateOptions(), cancel(), _createAnimations(), _createDescriptors(), _descriptors(), ka(), _notify() (+7 more)

### Community 36 - "P"
Cohesion: 0.06
Nodes (45): addControllers(), addElements(), addPlugins(), addScales(), as(), At(), Bs(), buildOrUpdateControllers() (+37 more)

### Community 37 - "PageSection"
Cohesion: 0.08
Nodes (11): getLabel(), options(), SectionsRelationManager, PageSection, SectionType, PageSeeder, SectionType, SectionType (+3 more)

### Community 38 - "moveCursorInDirection"
Cohesion: 0.11
Nodes (23): ArrowLeft(), ArrowRight(), expandSelectionAroundCommonAttribute(), expandSelectionForEditing(), expandSelectionInDirection(), findNodeAndOffsetFromLocation(), getAttachmentAtRange(), getExpandedRangeInDirection() (+15 more)

### Community 39 - "setAttribute"
Cohesion: 0.09
Nodes (39): add(), applyKeyboardCommand(), attachmentDidChangeAttributes(), attachmentEditorDidRequestRemovalOfAttachment(), canBeGrouped(), checkValidity(), createCaptionElement(), createContentNodes() (+31 more)

### Community 40 - "AppHeader.vue"
Cohesion: 0.08
Nodes (22): ratios, sources, currentLabel, isCurrent(), page, root, cta, currentLocale (+14 more)

### Community 41 - "get"
Cohesion: 0.03
Nodes (113): abutsStart(), after(), Ag(), Al(), ar(), before(), count(), daysInMonth() (+105 more)

### Community 42 - "getLocationRange"
Cohesion: 0.07
Nodes (41): canAcceptDataTransfer(), canDecreaseNestingLevel(), canIncreaseNestingLevel(), compositionControllerDidFocus(), compositionDidRequestChangingSelectionToLocationRange(), createDOMRangeFromLocationRange(), createDOMRangeFromPoint(), createLocationRangeFromDOMRange() (+33 more)

### Community 43 - "Figma ↔ Code Fidelity Audit — SahraMarketing"
Cohesion: 0.05
Nodes (36): Capability gap (read this before the findings), Coverage so far, critical, critical, design-side note, Design-side questions (do not silently conform the code), Figma ↔ Code Fidelity Audit — SahraMarketing, Frame: Home — `1419:9192` (1440 desktop) (+28 more)

### Community 44 - "_update"
Cohesion: 0.09
Nodes (37): afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate(), beforeBuildTicks() (+29 more)

### Community 45 - "compilerOptions"
Cohesion: 0.06
Nodes (35): DOM, DOM.Iterable, ESNext, node, node_modules, public, resources/images/*, resources/js/**/*.d.ts (+27 more)

### Community 46 - "LeadMagnet.vue"
Cohesion: 0.14
Nodes (12): dialog, downloadChecklist(), downloadUrl, form, isComplete, isOpen, LeadMagnetSection, newsletterUrl (+4 more)

### Community 47 - "Vn"
Cohesion: 0.17
Nodes (28): _a(), ba(), Be(), br(), Ca(), ce(), Dn(), ea() (+20 more)

### Community 48 - "wn"
Cohesion: 0.11
Nodes (21): clear(), cn(), Da(), Fd(), fh(), first(), gc(), _getLegendItemAt() (+13 more)

### Community 49 - "Illuminate\Database\Eloquent\Factories\Factory"
Cohesion: 0.15
Nodes (7): ContactSubmissionFactory, NewsletterSubscriptionFactory, PageFactory, static, static, UserFactory, Illuminate\Database\Eloquent\Factories\Factory

### Community 50 - "getProps"
Cohesion: 0.14
Nodes (18): average(), getBasePosition(), getBaseValue(), getCenterPoint(), getProps(), hasValue(), hs(), inRange() (+10 more)

### Community 51 - "getDatasetMeta"
Cohesion: 0.08
Nodes (38): addElements(), afterDatasetsUpdate(), buildOrUpdateControllers(), buildOrUpdateElements(), _checkEventBindings(), _dataCheck(), _destroy(), _destroyDatasetMeta() (+30 more)

### Community 52 - "fn"
Cohesion: 0.16
Nodes (26): Qt(), aa(), da(), fa(), Fi(), fn(), gr(), Ii() (+18 more)

### Community 53 - "buildTicks"
Cohesion: 0.06
Nodes (41): _a(), add(), afterAutoSkip(), Ai(), bf(), buildLookupTable(), buildTicks(), daysInYear() (+33 more)

### Community 54 - "Sahra — Final Figma Parity Verification"
Cohesion: 0.06
Nodes (33): 10. Phase 5 — fixes applied, 11. Live verification (Playwright vs Figma renders), 12. Vertical rhythm retune — home desktop (findings 13–18), 1. Why this cannot be a PASS, 2. Coverage, 3.1 Hardcoded hex distribution, 3. Findings, 4. What actually PASSED (+25 more)

### Community 55 - "determineDataLimits"
Cohesion: 0.29
Nodes (10): aa(), determineDataLimits(), Dh(), getMinMax(), _getOtherScale(), getUserBounds(), handleTickRangeOptions(), lt() (+2 more)

### Community 56 - "notifyEditorElement"
Cohesion: 0.09
Nodes (26): actionIsExternal(), canBeConsolidatedWith(), canInvokeAction(), compositionControllerDidBlur(), compositionControllerDidRender(), compositionControllerDidSyncDocumentView(), compositionDidAddAttachment(), compositionDidChangeAttachmentPreviewURL() (+18 more)

### Community 57 - "Error.vue"
Cohesion: 0.20
Nodes (9): currentLocale, homeUrl, key, known, message, page, props, { t } (+1 more)

### Community 58 - "echo.js"
Cohesion: 0.10
Nodes (13): a(), ar(), at(), cr(), d(), f(), H(), ji() (+5 more)

### Community 59 - "preload"
Cohesion: 0.07
Nodes (32): attachmentForFile(), attributesForFile(), canSetCurrentTextAttribute(), didChangeAttributes(), didClickAttachment(), dragstart(), findAttachmentForElement(), getAttachmentAndPositionById() (+24 more)

### Community 60 - "getDatasetMeta"
Cohesion: 0.11
Nodes (26): afterDatasetsUpdate(), _d(), generateLabels(), getDatasetMeta(), getDataVisibility(), getMaxBorderWidth(), getStyle(), _handleEvent() (+18 more)

### Community 61 - "AppFooter.vue"
Cohesion: 0.20
Nodes (8): columns, footerFont, page, privacyUrl, settings, { t }, termsUrl, year

### Community 62 - "m"
Cohesion: 0.22
Nodes (26): Bi(), d(), Di(), f(), Ge(), h(), I(), ja() (+18 more)

### Community 63 - "index.ts"
Cohesion: 0.06
Nodes (36): faqSection, faqSubtitle, hero, heroCtas, heroStack, insights, insightsSubtitle, kpi (+28 more)

### Community 64 - "vue"
Cohesion: 0.09
Nodes (19): vue, glow, horizonSrc, page, isArabic, page, PackageItem, component (+11 more)

### Community 65 - "useMotion.ts"
Cohesion: 0.12
Nodes (24): setup(), isTallerThanViewport(), MotionTarget, resolve(), useAutoReveal(), useCounters(), useEffectScope(), useHeroStagger() (+16 more)

### Community 66 - "Work/Show.vue"
Cohesion: 0.20
Nodes (8): activeShowcaseIndex, info, intro, pageRoot, props, resultIcons, showcaseFilters, { t }

### Community 67 - "SeoHead.vue"
Cohesion: 0.07
Nodes (29): articleLd, breadcrumbLd, description, image, locale, organizationLd, page, props (+21 more)

### Community 68 - "devDependencies"
Cohesion: 0.11
Nodes (19): autoprefixer, concurrently, eslint, laravel-vite-plugin, devDependencies, autoprefixer, concurrently, eslint (+11 more)

### Community 69 - "_notify"
Cohesion: 0.20
Nodes (14): active(), _animateOptions(), cancel(), _createAnimations(), _createDescriptors(), _descriptors(), kh(), _notify() (+6 more)

### Community 70 - "A"
Cohesion: 0.10
Nodes (28): cf(), da(), ef(), fa(), Jc(), Ln(), ma(), no() (+20 more)

### Community 72 - "AdminPanelProvider.php"
Cohesion: 0.47
Nodes (3): AdminPanelProvider, Filament\Panel, Filament\PanelProvider

### Community 74 - "T"
Cohesion: 0.14
Nodes (30): Ae(), ar(), at(), Cn(), de(), dt(), En(), fr() (+22 more)

### Community 75 - "Illuminate\Console\Command"
Cohesion: 0.40
Nodes (3): PublishScheduledContent, VerifyAssets, Illuminate\Console\Command

### Community 77 - "appendBlockForElement"
Cohesion: 0.18
Nodes (20): appendAttachmentWithAttributes(), appendBlockForAttributesWithElement(), appendBlockForElement(), appendBlockForTextNode(), appendEmptyBlock(), appendPiece(), appendStringWithAttributes(), find() (+12 more)

### Community 78 - "updateElements"
Cohesion: 0.04
Nodes (85): Ah(), applyStack(), aspectRatio(), Ca(), _calculateBarIndexPixels(), _calculateBarValuePixels(), cd(), Ce() (+77 more)

### Community 79 - "dependencies"
Cohesion: 0.12
Nodes (17): axios, countries-list, gsap, lucide-vue-next, dependencies, axios, countries-list, gsap (+9 more)

### Community 80 - "t"
Cohesion: 0.15
Nodes (14): Ce(), De(), di(), e(), Ht(), Ie(), Me(), Re() (+6 more)

### Community 82 - "render"
Cohesion: 0.07
Nodes (36): cacheViewForObject(), canSyncDocumentView(), compositionDidChangeDocument(), compositionDidLoadSnapshot(), createAttachmentNodes(), createChildView(), createContainerElement(), createDocumentFragmentForSync() (+28 more)

### Community 84 - "Contact.vue"
Cohesion: 0.10
Nodes (16): countries, countryOpen, countryPicker, countrySearch, details, filteredCountries, form, page (+8 more)

### Community 85 - "Insights/Show.vue"
Cohesion: 0.17
Nodes (10): ArticlePart, articleParts, copied, linkedInShare, meta, page, props, shareUrl (+2 more)

### Community 86 - "ProjectsShowcase.vue"
Cohesion: 0.09
Nodes (20): activeIndex, activeProject, canRotate, handlePointerUp(), handleVisibilityChange(), isPaused, isVisible, mobileActiveIndex (+12 more)

### Community 87 - "composer.json"
Cohesion: 0.15
Nodes (12): autoload-dev, psr-4, description, extra, laravel, dont-discover, license, minimum-stability (+4 more)

### Community 88 - "scripts"
Cohesion: 0.12
Nodes (17): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, test, Composer\\Config::disableProcessTimeout (+9 more)

### Community 89 - "scripts"
Cohesion: 0.25
Nodes (8): scripts, build, dev, format, lint, test:e2e, test:e2e:ui, typecheck

### Community 90 - "app.js"
Cohesion: 0.26
Nodes (7): C(), D(), J(), O(), U(), v(), X()

### Community 91 - "r"
Cohesion: 0.18
Nodes (12): Be(), ei(), ii(), le(), ni(), oi(), r(), ri() (+4 more)

### Community 92 - "i"
Cohesion: 0.20
Nodes (11): b(), Dt(), Fe(), g(), He(), i(), ir(), Mt() (+3 more)

### Community 93 - "AppServiceProvider"
Cohesion: 0.28
Nodes (4): AppServiceProvider, Illuminate\Support\ServiceProvider, vite, vite

### Community 94 - "require"
Cohesion: 0.12
Nodes (16): require, filament/filament, inertiajs/inertia-laravel, laravel/framework, laravel/tinker, openspout/openspout, php, spatie/laravel-permission (+8 more)

### Community 95 - "require-dev"
Cohesion: 0.20
Nodes (10): require-dev, fakerphp/faker, laravel/pail, laravel/pint, laravel/sail, mockery/mockery, nunomaduro/collision, pestphp/pest (+2 more)

### Community 96 - "ServicesOrbit.vue"
Cohesion: 0.27
Nodes (9): innerRing, mobileRing, outerRing, pills, props, serviceFor(), serviceLabel(), ServiceSection (+1 more)

### Community 97 - "useTranslations.ts"
Cohesion: 0.10
Nodes (15): props, { t }, ComponentCustomProperties, Replacements, useTranslations(), vue, basePath, hasMore (+7 more)

### Community 99 - "What You Must Do When Invoked"
Cohesion: 0.08
Nodes (24): For /graphify add and --watch, For /graphify query, For the commit hook and native CLAUDE.md integration, For --update and --cluster-only, /graphify, Honesty Rules, Interpreter guard for subcommands, Part A - Structural extraction for code files (+16 more)

### Community 102 - "Figma Audit — SahraMarketing"
Cohesion: 0.08
Nodes (23): 1. Frame-set resolution, 2. Design tokens (extracted from Figma variables), 3. Shared component inventory (page `1:2`), 4. Route inventory, 5. Section inventory — Home (`1419:9192`), 6. Animation inventory, 6b. Prototype interactions stored in the file, 7. Form inventory (+15 more)

### Community 103 - "ProcessSection.vue"
Cohesion: 0.40
Nodes (3): iconKeys, ProcessItem, singleAssetIcons

### Community 104 - "config"
Cohesion: 0.22
Nodes (9): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, platform, preferred-install, sort-packages (+1 more)

### Community 106 - "I"
Cohesion: 0.10
Nodes (35): C(), Co(), cr(), endOf(), Et(), format(), formats(), getLabelAndValue() (+27 more)

### Community 107 - "User.php"
Cohesion: 0.24
Nodes (4): RolePermissionSeeder, Filament\Models\Contracts\FilamentUser, Illuminate\Notifications\Notifiable, Spatie\Permission\Traits\HasRoles

### Community 109 - "Asset Manifest"
Cohesion: 0.11
Nodes (17): 0. Bulk export (do this first), 10. Fonts — ACTION REQUIRED, 10b. Exported via the REST API, 11. Export-completeness checklist, 1. Branding, 2. Home page, 3. Client logos (trust proof strip), 4. Projects (+9 more)

### Community 111 - ".scratch-mobile-figma-audit.mjs"
Cohesion: 0.50
Nodes (3): errors, results, routes

### Community 113 - "Architecture"
Cohesion: 0.12
Nodes (14): Architecture, Commands, Controller → Transformer → TypeScript contract, Conventions, Current state, Environment gotchas, Filament admin, Frontend (+6 more)

### Community 114 - "psr-4"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 115 - "keywords"
Cohesion: 0.40
Nodes (5): keywords, filament, inertia, laravel, multilingual

### Community 116 - "Per-page breakdown"
Cohesion: 0.15
Nodes (12): About (`908:1576` / `1557:12225`), Blog listing / single blog (`1353:7935`, `1352:7391`), Contact (`1363:8934` / `1494:9544`), Global rules (every breakpoint), Home (`1419:9192` / `1419:9191`), Manual QA checklist (run per release), Per-page breakdown, Responsive QA (+4 more)

### Community 117 - "graphify reference: extra exports and benchmark"
Cohesion: 0.22
Nodes (8): graphify reference: extra exports and benchmark, Step 6b - Wiki (only if --wiki flag), Step 7 - Neo4j export (only if --neo4j or --neo4j-push flag), Step 7a - FalkorDB export (only if --falkordb or --falkordb-push flag), Step 7b - SVG export (only if --svg flag), Step 7c - GraphML export (only if --graphml flag), Step 7d - MCP server (only if --mcp flag), Step 8 - Token reduction benchmark (only if total_words > 5000)

### Community 119 - "Sahra Marketing"
Cohesion: 0.22
Nodes (8): 1. Requirements, 2. Installation, 3. Running locally, 4. Testing, 5. Production build & deployment, 6. Project structure, 7. Known limitations, Sahra Marketing

### Community 131 - "Implementation Log"
Cohesion: 0.29
Nodes (6): Implementation Log, Known limitations, Phase 1 — Figma audit, Phase 2 — Foundation, Phase 3 — Backend & admin, Phases 4–9 — Delivered inline with Phase 2/3

### Community 146 - "package.json"
Cohesion: 0.50
Nodes (3): name, private, type

### Community 208 - "graphify reference: query, path, explain"
Cohesion: 0.33
Nodes (5): For /graphify explain, For /graphify path, graphify reference: query, path, explain, Step 0 — Constrained query expansion (REQUIRED before traversal), Step 1 — Traversal

### Community 210 - "Traceability Matrix"
Cohesion: 0.40
Nodes (4): Animations, Pages, Shared components, Traceability Matrix

### Community 211 - "graphify reference: add a URL and watch a folder"
Cohesion: 0.50
Nodes (3): For /graphify add, For --watch, graphify reference: add a URL and watch a folder

### Community 212 - "graphify reference: commit hook and native CLAUDE.md integration"
Cohesion: 0.50
Nodes (3): For git commit hook, For native CLAUDE.md integration, graphify reference: commit hook and native CLAUDE.md integration

### Community 213 - "graphify reference: incremental update and cluster-only"
Cohesion: 0.50
Nodes (3): For --cluster-only, For --update (incremental re-extraction), graphify reference: incremental update and cluster-only

### Community 214 - "Content TODO — real assets and copy still needed"
Cohesion: 0.50
Nodes (3): 1. Duplicate team portraits (About page), 2. Arabic copy review, Content TODO — real assets and copy still needed

## Knowledge Gaps
- **494 isolated node(s):** `faOption`, `errors`, `routes`, `results`, `errors` (+489 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **45 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `F()` connect `select.js` to `draw`, `rich-editor.js`, `stat/chart.js`, `draw`, `T`, `x`, `color-picker.js`, `support.js`, `ec`, `m`?**
  _High betweenness centrality (0.043) - this node is a cross-community bridge._
- **Why does `draw()` connect `draw` to `components/chart.js`, `A`, `_update`, `updateElements`, `wn`, `qt`, `D`, `select.js`, `m`?**
  _High betweenness centrality (0.041) - this node is a cross-community bridge._
- **Why does `A()` connect `A` to `draw`, `rich-editor.js`, `draw`, `ce`, `setAttribute`, `constructor`, `file-upload.js`, `x`, `buildTicks`, `deleteInDirection`, `fn`, `select.js`, `markdown-editor.js`, `m`?**
  _High betweenness centrality (0.039) - this node is a cross-community bridge._
- **Are the 13 inferred relationships involving `x()` (e.g. with `de()` and `g()`) actually correct?**
  _`x()` has 13 INFERRED edges - model-reasoned connections that need verification._
- **Are the 19 inferred relationships involving `te()` (e.g. with `je()` and `Pr()`) actually correct?**
  _`te()` has 19 INFERRED edges - model-reasoned connections that need verification._
- **What connects `faOption`, `errors`, `routes` to the rest of the system?**
  _494 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `components/chart.js` be split into smaller, more focused modules?**
  _Cohesion score 0.011522238606357807 - nodes in this community are weakly interconnected._