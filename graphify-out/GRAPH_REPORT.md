# Graph Report - sahra  (2026-08-26)

## Corpus Check
- 369 files · ~2,230,086 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 4946 nodes · 12559 edges · 227 communities (195 shown, 32 thin omitted)
- Extraction: 91% EXTRACTED · 9% INFERRED · 0% AMBIGUOUS · INFERRED: 1184 edges (avg confidence: 0.68)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `78b0495f`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- components/chart.js
- rich-editor.js
- stat/chart.js
- P
- Filament\Resources\Pages\EditRecord
- Post
- getLength
- _update
- constructor
- Illuminate\Database\Eloquent\Model
- deleteInDirection
- constructor
- format
- file-upload.js
- SiteSettings
- Project
- x
- Page
- updateElements
- getSelectedRange
- addEventListener
- te
- Filament\Resources\Pages\ListRecords
- select.js
- ContactSubmissionRequest
- insertString
- support.js
- markdown-editor.js
- Filament\Forms\Form
- T
- Y
- HandlesTranslations.php
- draw
- constructor
- notifications.js
- qi
- qt
- Illuminate\Database\Seeder
- sf
- setAttribute
- AppHeader.vue
- updateElements
- getLocationRange
- Figma ↔ Code Fidelity Audit — SahraMarketing
- _update
- compilerOptions
- LeadMagnet.vue
- Vn
- draw
- PublicationStatus.php
- vue
- getDatasetMeta
- fn
- PageSection
- Sahra — Final Figma Parity Verification
- St
- notifyEditorElement
- buildTicks
- echo.js
- preload
- getDatasetMeta
- Client
- m
- index.ts
- TeamMemberResource
- useMotion.ts
- serializeSelectionToDataTransfer
- SeoHead.vue
- devDependencies
- get
- a
- Illuminate\Database\Eloquent\Builder
- .handle
- ManageSettings
- qe
- a
- AppFooter.vue
- appendBlockForElement
- yn
- dependencies
- t
- color-picker.js
- render
- qt
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
- D
- le
- Figma Audit — SahraMarketing
- Error.vue
- config
- pe
- I
- BasePolicy
- Be
- Asset Manifest
- ContactSubmissionResource
- .scratch-mobile-figma-audit.mjs
- @inertiajs/vue3
- Architecture
- psr-4
- keywords
- Per-page breakdown
- graphify reference: extra exports and benchmark
- Illuminate\Console\Command
- Sahra Marketing
- Numerals.php
- ItemsRelationManager
- Implementation Log
- .scratch-navbar.mjs
- check_color2.tmp.mjs
- check_color3.tmp.mjs
- ProcessSection.vue
- 2026_07_27_000002_publish_home_packages.php
- check_color.tmp.mjs
- crop_dots.tmp.mjs
- typescript
- @vitejs/plugin-vue
- .scratch-locale-persist.mjs
- fetch-fonts.sh
- responsive.spec.ts
- screenshot_dots.tmp.mjs
- graphify reference: query, path, explain
- Traceability Matrix
- graphify reference: add a URL and watch a folder
- graphify reference: commit hook and native CLAUDE.md integration
- graphify reference: incremental update and cluster-only
- Content TODO — real assets and copy still needed
- graphify reference: GitHub clone and cross-repo merge
- graphify reference: transcribe video and audio
- graphify
- extraction-spec.md
- entrypoint.sh
- @playwright/test
- tailwindcss
- .playwright-inspect.mjs
- prettier
- @vue/eslint-config-typescript

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
- `constructor()` --indirect_call--> `Yn()`  [INFERRED]
  public/js/filament/widgets/components/stats-overview/stat/chart.js → public/js/filament/filament/echo.js
- `dt()` --indirect_call--> `Ht()`  [INFERRED]
  public/js/filament/forms/components/rich-editor.js → public/js/filament/forms/components/markdown-editor.js
- `mutateFormDataBeforeCreate()` --calls--> `TranslatableForm`  [INFERRED]
  app/Filament/Concerns/HandlesTranslations.php → app/Filament/Support/TranslatableForm.php
- `mutateFormDataBeforeSave()` --calls--> `TranslatableForm`  [INFERRED]
  app/Filament/Concerns/HandlesTranslations.php → app/Filament/Support/TranslatableForm.php

## Import Cycles
- None detected.

## Communities (227 total, 32 thin omitted)

### Community 0 - "components/chart.js"
Cohesion: 0.01
Nodes (110): acquireContext(), addControllers(), addPlugins(), addScales(), afterDraw(), alpha(), beforeDatasetDraw(), beforeDatasetsDraw() (+102 more)

### Community 1 - "rich-editor.js"
Cohesion: 0.02
Nodes (121): activateAttributeIfSupported(), appendStringToTextAtIndex(), applyBlockAttribute(), attachmentDidChangeAttributes(), attachmentDidChangeUploadProgress(), attachmentIsManaged(), attributeChangedCallback(), canRedo() (+113 more)

### Community 2 - "stat/chart.js"
Cohesion: 0.02
Nodes (121): aa(), active(), addControllers(), addPlugins(), addScales(), al(), an(), _animateOptions() (+113 more)

### Community 3 - "P"
Cohesion: 0.07
Nodes (39): as(), At(), Bs(), cc(), De(), Ea(), ed(), Fc() (+31 more)

### Community 4 - "Filament\Resources\Pages\EditRecord"
Cohesion: 0.05
Nodes (17): EditClient, EditContactSubmission, EditFaq, EditIndustry, EditMenu, EditPage, EditPostCategory, EditPost (+9 more)

### Community 5 - "Post"
Cohesion: 0.09
Nodes (9): LeadMagnetDownloadController, SitemapController, Post, publish(), PostSeeder, Illuminate\Http\Response, Illuminate\Support\Carbon, Symfony\Component\HttpFoundation\BinaryFileResponse (+1 more)

### Community 6 - "getLength"
Cohesion: 0.04
Nodes (112): addAttribute(), addAttributeAtRange(), addAttributesAtRange(), addHTMLAttribute(), appendText(), applyBlockAttributeAtRange(), charAt(), compositionControllerDidRequestDeselectingAttachment() (+104 more)

### Community 7 - "_update"
Cohesion: 0.04
Nodes (91): addBox(), afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate() (+83 more)

### Community 8 - "constructor"
Cohesion: 0.07
Nodes (35): box(), canBeConsolidatedWith(), canBeGroupedWith(), canDecreaseBlockAttributeLevel(), compositionControllerDidRender(), constructor(), formDisabledCallback(), fromUCS2String() (+27 more)

### Community 9 - "Illuminate\Database\Eloquent\Model"
Cohesion: 0.03
Nodes (40): Industry, MenuItem, PostCategory, PostTag, ProjectImage, Redirect, SectionItem, ClientTranslation (+32 more)

### Community 10 - "deleteInDirection"
Cohesion: 0.07
Nodes (40): ArrowLeft(), ArrowRight(), backspace(), d(), delete(), deleteByComposition(), deleteByCut(), deleteCompositionText() (+32 more)

### Community 11 - "constructor"
Cohesion: 0.03
Nodes (121): _a(), abutsStart(), after(), afterAutoSkip(), Ag(), Ai(), Al(), before() (+113 more)

### Community 12 - "format"
Cohesion: 0.05
Nodes (63): Bl(), cf(), clone(), create(), dtFormatter(), eg(), el(), eras() (+55 more)

### Community 13 - "file-upload.js"
Cohesion: 0.04
Nodes (60): ba(), bi(), c(), ca(), clickPercent(), constructor(), define(), e() (+52 more)

### Community 14 - "SiteSettings"
Cohesion: 0.06
Nodes (10): getLabel(), options(), HandleInertiaRequests, Menu, Setting, SocialLink, LocaleAlternates, SiteSettings (+2 more)

### Community 15 - "Project"
Cohesion: 0.07
Nodes (8): Project, ContentTransformer, SectionType, MediaTransformer, NavigationBuilder, Numerals, Illuminate\Support\Collection, self

### Community 16 - "x"
Cohesion: 0.12
Nodes (72): Ae(), as(), at(), B(), br(), Bt(), Cr(), Ct() (+64 more)

### Community 17 - "Page"
Cohesion: 0.08
Nodes (17): AboutController, AdminLocaleController, ContactController, Controller, HomeController, LegalController, NewsletterController, PostController (+9 more)

### Community 18 - "updateElements"
Cohesion: 0.04
Nodes (77): Ao(), applyStack(), ar(), as(), buildTicks(), _calculateBarIndexPixels(), _calculateBarValuePixels(), calculateCircumference() (+69 more)

### Community 19 - "getSelectedRange"
Cohesion: 0.07
Nodes (55): attachmentManagerDidRequestRemovalOfAttachment(), breakFormattedBlock(), breaksOnReturn(), Ca(), canSetCurrentAttribute(), canSetCurrentBlockAttribute(), compositionControllerDidRequestRemovalOfAttachment(), compositionDidRequestChangingSelectionToLocationRange() (+47 more)

### Community 20 - "addEventListener"
Cohesion: 0.08
Nodes (29): addEventListener(), bindEvents(), bindResponsiveEvents(), bindUserEvents(), dn(), Du(), Ef(), features() (+21 more)

### Community 21 - "te"
Cohesion: 0.04
Nodes (13): Pr(), Bi(), bn(), Id(), ji(), kd(), qi(), Ri() (+5 more)

### Community 22 - "Filament\Resources\Pages\ListRecords"
Cohesion: 0.05
Nodes (18): ListClients, ListContactSubmissions, ListFaqs, ListIndustries, ListMenus, ListNewsletterSubscriptions, ListPages, ListPostCategories (+10 more)

### Community 23 - "select.js"
Cohesion: 0.07
Nodes (67): [g](), [x](), Sg(), $c(), ca(), D(), E(), g() (+59 more)

### Community 24 - "ContactSubmissionRequest"
Cohesion: 0.05
Nodes (15): getLabel(), options(), ContactSubmissionRequest, NewsletterSubscriptionRequest, ContactSubmission, NewsletterSubscription, ContactSubmissionReceived, Illuminate\Bus\Queueable (+7 more)

### Community 25 - "insertString"
Cohesion: 0.05
Nodes (64): attachFiles(), canApplyToDocument(), compositionstart(), compositionupdate(), createLinkHTML(), deleteByDrag(), dragend(), elementDidMutate() (+56 more)

### Community 26 - "support.js"
Cohesion: 0.06
Nodes (40): ai(), apply(), B(), co(), Cr(), $e(), es(), Et() (+32 more)

### Community 27 - "markdown-editor.js"
Cohesion: 0.03
Nodes (168): getExtension(), _getTestState(), _a(), Aa(), af(), ai(), al(), An() (+160 more)

### Community 28 - "Filament\Forms\Form"
Cohesion: 0.11
Nodes (11): Resource, MenuResource, NewsletterSubscriptionResource, ImagesRelationManager, RedirectResource, SocialLinkResource, Filament\Forms\Components\Section, Filament\Forms\Form (+3 more)

### Community 29 - "T"
Cohesion: 0.07
Nodes (42): xg(), acquireContext(), Ai(), aspectRatio(), ca(), drawGrid(), ec(), Fc() (+34 more)

### Community 30 - "Y"
Cohesion: 0.11
Nodes (27): ac(), afterAutoSkip(), Bi(), buildLookupTable(), determineDataLimits(), endOf(), Fi(), getAllParsedValues() (+19 more)

### Community 31 - "HandlesTranslations.php"
Cohesion: 0.06
Nodes (22): handleRecordCreation(), handleRecordUpdate(), mutateFormDataBeforeCreate(), mutateFormDataBeforeFill(), mutateFormDataBeforeSave(), CreateClient, CreateFaq, CreateIndustry (+14 more)

### Community 32 - "draw"
Cohesion: 0.10
Nodes (35): adjustHitBoxes(), bc(), Bl(), clear(), _computeLabelArea(), _computeTitleHeight(), _createItems(), da() (+27 more)

### Community 33 - "constructor"
Cohesion: 0.07
Nodes (36): _a(), ba(), _cachedScopes(), chartOptionScopes(), configure(), constructor(), createResolver(), datasetElementScopeKeys() (+28 more)

### Community 34 - "notifications.js"
Cohesion: 0.06
Nodes (24): actions(), button(), constructor(), danger(), dispatch(), dispatchSelf(), dispatchTo(), duration() (+16 more)

### Community 35 - "qi"
Cohesion: 0.16
Nodes (17): average(), fn(), getCenterPoint(), getProps(), hasValue(), inRange(), Is(), Ma() (+9 more)

### Community 36 - "qt"
Cohesion: 0.04
Nodes (67): Ac(), an(), Au(), average(), ba(), beforeDraw(), bu(), cd() (+59 more)

### Community 37 - "Illuminate\Database\Seeder"
Cohesion: 0.19
Nodes (5): DatabaseSeeder, PageSeeder, SectionType, ServiceSeeder, Illuminate\Database\Seeder

### Community 38 - "sf"
Cohesion: 0.25
Nodes (9): eh(), Gi(), ih(), Me(), qi(), sf(), sh(), vo() (+1 more)

### Community 39 - "setAttribute"
Cohesion: 0.10
Nodes (36): add(), applyKeyboardCommand(), attachmentEditorDidRequestRemovalOfAttachment(), canBeGrouped(), checkValidity(), createCaptionElement(), dialogIsVisible(), didClickActionButton() (+28 more)

### Community 40 - "AppHeader.vue"
Cohesion: 0.06
Nodes (25): ratios, sources, isArabic, page, currentLabel, page, root, PackageItem (+17 more)

### Community 41 - "updateElements"
Cohesion: 0.05
Nodes (69): addElements(), applyStack(), aspectRatio(), buildOrUpdateElements(), Ca(), _calculateBarIndexPixels(), _calculateBarValuePixels(), calculateCircumference() (+61 more)

### Community 42 - "getLocationRange"
Cohesion: 0.07
Nodes (40): canAcceptDataTransfer(), canDecreaseNestingLevel(), canIncreaseNestingLevel(), compositionControllerDidFocus(), createDOMRangeFromLocationRange(), createDOMRangeFromPoint(), createLocationRangeFromDOMRange(), decreaseNestingLevel() (+32 more)

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
Nodes (32): _a(), aa(), ba(), Be(), br(), Ca(), ce(), Dn() (+24 more)

### Community 48 - "draw"
Cohesion: 0.05
Nodes (99): ad(), adjustHitBoxes(), ae(), af(), C(), calculateLabelRotation(), _computeAngle(), _computeGridLineItems() (+91 more)

### Community 49 - "PublicationStatus.php"
Cohesion: 0.05
Nodes (13): getLabel(), options(), ContactSubmissionFactory, NewsletterSubscriptionFactory, PageFactory, static, static, PostFactory (+5 more)

### Community 50 - "vue"
Cohesion: 0.11
Nodes (15): vue, glow, horizonSrc, page, component, icons, props, activeShowcaseIndex (+7 more)

### Community 51 - "getDatasetMeta"
Cohesion: 0.07
Nodes (47): addElements(), afterDatasetsUpdate(), afterDraw(), beforeUpdate(), buildOrUpdateControllers(), buildOrUpdateElements(), _checkEventBindings(), _dataCheck() (+39 more)

### Community 52 - "fn"
Cohesion: 0.14
Nodes (30): Qt(), Cn(), da(), En(), fa(), Fi(), fn(), h() (+22 more)

### Community 53 - "PageSection"
Cohesion: 0.10
Nodes (9): getLabel(), options(), SectionsRelationManager, PageSection, SectionType, SectionType, ProjectSeeder, Illuminate\Database\Eloquent\Relations\MorphMany (+1 more)

### Community 54 - "Sahra — Final Figma Parity Verification"
Cohesion: 0.06
Nodes (33): 10. Phase 5 — fixes applied, 11. Live verification (Playwright vs Figma renders), 12. Vertical rhythm retune — home desktop (findings 13–18), 1. Why this cannot be a PASS, 2. Coverage, 3.1 Hardcoded hex distribution, 3. Findings, 4. What actually PASSED (+25 more)

### Community 55 - "St"
Cohesion: 0.06
Nodes (42): alpha(), be(), beforeDraw(), dataset(), ea(), en(), fe(), ge() (+34 more)

### Community 56 - "notifyEditorElement"
Cohesion: 0.12
Nodes (20): actionIsExternal(), canInvokeAction(), compositionControllerDidBlur(), compositionControllerDidSyncDocumentView(), compositionDidAddAttachment(), compositionDidChangeAttachmentPreviewURL(), compositionDidChangeCurrentAttributes(), compositionDidEditAttachment() (+12 more)

### Community 57 - "buildTicks"
Cohesion: 0.06
Nodes (43): aa(), Ah(), ar(), bf(), buildTicks(), _calculatePadding(), determineDataLimits(), Dh() (+35 more)

### Community 58 - "echo.js"
Cohesion: 0.11
Nodes (10): ar(), b(), cr(), g(), Me(), P(), qt(), rr() (+2 more)

### Community 59 - "preload"
Cohesion: 0.10
Nodes (23): attachmentForFile(), attributesForFile(), compositionShouldAcceptFile(), didChangeAttributes(), getContentType(), getCurrentTextAttributes(), getHeight(), getHref() (+15 more)

### Community 60 - "getDatasetMeta"
Cohesion: 0.09
Nodes (33): afterDatasetsUpdate(), buildOrUpdateControllers(), _d(), _destroyDatasetMeta(), Fd(), first(), generateLabels(), getDatasetMeta() (+25 more)

### Community 61 - "Client"
Cohesion: 0.11
Nodes (5): Client, Faq, TeamMember, Testimonial, ContentSeeder

### Community 62 - "m"
Cohesion: 0.22
Nodes (26): Bi(), d(), Di(), f(), Ge(), I(), ir(), ja() (+18 more)

### Community 63 - "index.ts"
Cohesion: 0.06
Nodes (36): faqSection, faqSubtitle, hero, heroCtas, heroStack, insights, insightsSubtitle, kpi (+28 more)

### Community 65 - "useMotion.ts"
Cohesion: 0.12
Nodes (25): setup(), isTallerThanViewport(), MotionTarget, resolve(), useAutoReveal(), useCounters(), useEffectScope(), useHeroStagger() (+17 more)

### Community 66 - "serializeSelectionToDataTransfer"
Cohesion: 0.12
Nodes (18): canSetCurrentTextAttribute(), cut(), didClickAttachment(), dragstart(), findAttachmentForElement(), getAttachmentAndPositionById(), getAttachmentById(), getAttachmentPieces() (+10 more)

### Community 67 - "SeoHead.vue"
Cohesion: 0.07
Nodes (28): articleLd, breadcrumbLd, description, locale, organizationLd, page, props, settings (+20 more)

### Community 68 - "devDependencies"
Cohesion: 0.09
Nodes (23): autoprefixer, concurrently, eslint, eslint-plugin-vue, laravel-vite-plugin, devDependencies, autoprefixer, concurrently (+15 more)

### Community 69 - "get"
Cohesion: 0.08
Nodes (34): active(), add(), _animateOptions(), Bi(), _cachedScopes(), cancel(), _createAnimations(), _createDescriptors() (+26 more)

### Community 70 - "a"
Cohesion: 0.10
Nodes (43): e(), i(), l(), Ni(), o(), t(), u(), be() (+35 more)

### Community 71 - "Illuminate\Database\Eloquent\Builder"
Cohesion: 0.03
Nodes (20): ClientResource, ViewContactSubmission, FaqResource, IndustryResource, PageResource, PostCategoryResource, PostResource, PostTagResource (+12 more)

### Community 72 - ".handle"
Cohesion: 0.14
Nodes (10): RedirectToLocalisedRoute, SetAdminLocale, SetLocale, AdminPanelProvider, Carbon\Carbon, Closure, Filament\Panel, Filament\PanelProvider (+2 more)

### Community 73 - "ManageSettings"
Cohesion: 0.16
Nodes (8): ManageSettings, Tabs, Tabs, Filament\Forms\Components\Tabs, Filament\Forms\Concerns\InteractsWithForms, Filament\Forms\Contracts\HasForms, Filament\Notifications\Notification, Filament\Pages\Page

### Community 74 - "qe"
Cohesion: 0.23
Nodes (18): Ae(), at(), de(), dt(), fr(), Gt(), ht(), It() (+10 more)

### Community 75 - "a"
Cohesion: 0.25
Nodes (8): a(), at(), d(), f(), H(), ji(), L(), pt()

### Community 76 - "AppFooter.vue"
Cohesion: 0.20
Nodes (8): columns, footerFont, page, privacyUrl, settings, { t }, termsUrl, year

### Community 77 - "appendBlockForElement"
Cohesion: 0.20
Nodes (19): appendAttachmentWithAttributes(), appendBlockForAttributesWithElement(), appendBlockForElement(), appendBlockForTextNode(), appendEmptyBlock(), appendPiece(), appendStringWithAttributes(), find() (+11 more)

### Community 78 - "yn"
Cohesion: 0.33
Nodes (7): ar(), ft(), kn(), sr(), wn(), Ye(), yn()

### Community 79 - "dependencies"
Cohesion: 0.11
Nodes (19): axios, countries-list, flag-icons, gsap, lucide-vue-next, dependencies, axios, countries-list (+11 more)

### Community 80 - "t"
Cohesion: 0.18
Nodes (12): Ce(), De(), di(), e(), Ht(), Ie(), Re(), t() (+4 more)

### Community 82 - "render"
Cohesion: 0.06
Nodes (41): beforeinput(), cacheViewForObject(), compositionDidChangeDocument(), compositionDidLoadSnapshot(), compositionend(), createAttachmentNodes(), createChildView(), createContainerElement() (+33 more)

### Community 83 - "qt"
Cohesion: 0.36
Nodes (8): hs(), Ln(), Nn(), ps(), qt(), Ro(), Se(), wo()

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
Cohesion: 0.17
Nodes (11): name, private, scripts, build, dev, format, lint, test:e2e (+3 more)

### Community 90 - "app.js"
Cohesion: 0.26
Nodes (7): C(), D(), J(), O(), U(), v(), X()

### Community 91 - "r"
Cohesion: 0.18
Nodes (12): Be(), ei(), ii(), le(), ni(), oi(), r(), ri() (+4 more)

### Community 92 - "i"
Cohesion: 0.29
Nodes (8): Dt(), Fe(), He(), i(), ir(), Mt(), nr(), rt()

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
Cohesion: 0.22
Nodes (9): ghostBrand, ghostProduct, pills, props, serviceFor(), serviceLabel(), ServiceSection, stage (+1 more)

### Community 97 - "useTranslations.ts"
Cohesion: 0.07
Nodes (23): props, { t }, ComponentCustomProperties, Replacements, useTranslations(), vue, basePath, leadRow (+15 more)

### Community 99 - "What You Must Do When Invoked"
Cohesion: 0.08
Nodes (24): For /graphify add and --watch, For /graphify query, For the commit hook and native CLAUDE.md integration, For --update and --cluster-only, /graphify, Honesty Rules, Interpreter guard for subcommands, Part A - Structural extraction for code files (+16 more)

### Community 100 - "D"
Cohesion: 0.05
Nodes (51): oe, addEventListener(), bindEvents(), bindResponsiveEvents(), bindUserEvents(), buildOrUpdateScales(), cl(), cs() (+43 more)

### Community 102 - "Figma Audit — SahraMarketing"
Cohesion: 0.08
Nodes (23): 1. Frame-set resolution, 2. Design tokens (extracted from Figma variables), 3. Shared component inventory (page `1:2`), 4. Route inventory, 5. Section inventory — Home (`1419:9192`), 6. Animation inventory, 6b. Prototype interactions stored in the file, 7. Form inventory (+15 more)

### Community 103 - "Error.vue"
Cohesion: 0.20
Nodes (9): currentLocale, homeUrl, key, known, message, page, props, { t } (+1 more)

### Community 104 - "config"
Cohesion: 0.22
Nodes (9): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, platform, preferred-install, sort-packages (+1 more)

### Community 106 - "I"
Cohesion: 0.09
Nodes (41): chartOptionScopes(), add(), br(), C(), Co(), _computeLabelSizes(), cr(), diff() (+33 more)

### Community 107 - "BasePolicy"
Cohesion: 0.03
Nodes (25): User, BasePolicy, ClientPolicy, ContactSubmissionPolicy, FaqPolicy, IndustryPolicy, MenuPolicy, NewsletterSubscriptionPolicy (+17 more)

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

### Community 118 - "Illuminate\Console\Command"
Cohesion: 0.40
Nodes (3): PublishScheduledContent, VerifyAssets, Illuminate\Console\Command

### Community 119 - "Sahra Marketing"
Cohesion: 0.20
Nodes (9): 1. Requirements, 2. Quick start with Docker, 3. Installation, 4. Running locally, 5. Testing, 6. Production build & deployment, 7. Project structure, 8. Known limitations (+1 more)

### Community 131 - "Implementation Log"
Cohesion: 0.29
Nodes (6): Implementation Log, Known limitations, Phase 1 — Figma audit, Phase 2 — Foundation, Phase 3 — Backend & admin, Phases 4–9 — Delivered inline with Phase 2/3

### Community 148 - "ProcessSection.vue"
Cohesion: 0.40
Nodes (3): iconKeys, ProcessItem, singleAssetIcons

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
- **504 isolated node(s):** `consoleMsgs`, `faOption`, `errors`, `routes`, `results` (+499 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **32 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `image` connect `file-upload.js` to `SeoHead.vue`?**
  _High betweenness centrality (0.110) - this node is a cross-community bridge._
- **Why does `define()` connect `file-upload.js` to `markdown-editor.js`, `a`?**
  _High betweenness centrality (0.080) - this node is a cross-community bridge._
- **Why does `vue` connect `vue` to `ServicesOrbit.vue`, `useMotion.ts`, `useTranslations.ts`, `SeoHead.vue`, `Error.vue`, `AppHeader.vue`, `AppFooter.vue`, `LeadMagnet.vue`, `keywords`, `Contact.vue`, `Insights/Show.vue`, `ProjectsShowcase.vue`, `index.ts`?**
  _High betweenness centrality (0.056) - this node is a cross-community bridge._
- **Are the 13 inferred relationships involving `x()` (e.g. with `de()` and `g()`) actually correct?**
  _`x()` has 13 INFERRED edges - model-reasoned connections that need verification._
- **Are the 19 inferred relationships involving `te()` (e.g. with `je()` and `Pr()`) actually correct?**
  _`te()` has 19 INFERRED edges - model-reasoned connections that need verification._
- **What connects `consoleMsgs`, `faOption`, `errors` to the rest of the system?**
  _504 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `components/chart.js` be split into smaller, more focused modules?**
  _Cohesion score 0.011382113821138212 - nodes in this community are weakly interconnected._