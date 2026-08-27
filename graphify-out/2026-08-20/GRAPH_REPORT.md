# Graph Report - sahra  (2026-08-20)

## Corpus Check
- 360 files · ~2,220,206 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 4921 nodes · 12528 edges · 229 communities (193 shown, 36 thin omitted)
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
- a
- getContext
- getLength
- _update
- insertString
- Illuminate\Database\Eloquent\Model
- BasePolicy
- Re
- constructor
- file-upload.js
- ManageSettings
- Post
- x
- Page
- updateElements
- getSelectedRange
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
- addEventListener
- HandlesTranslations.php
- draw
- D
- notifications.js
- getDatasetMeta
- _each
- PageSection
- deleteInDirection
- setAttribute
- AppHeader.vue
- fromObject
- withTargetDOMRange
- Figma ↔ Code Fidelity Audit — SahraMarketing
- _update
- compilerOptions
- LeadMagnet.vue
- Vn
- cd
- Illuminate\Database\Eloquent\Factories\Factory
- yn
- E
- fn
- get
- Sahra — Final Figma Parity Verification
- serializeSelectionToDataTransfer
- constructor
- constructor
- echo.js
- notifyEditorElement
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
- dispatch
- view
- T
- Illuminate\Console\Command
- PageSeeder
- appendBlockForElement
- updateElements
- dependencies
- t
- color-picker.js
- render
- P
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
- UserPolicy
- What You Must Do When Invoked
- ot
- le
- Figma Audit — SahraMarketing
- ProcessSection.vue
- config
- status
- I
- Project.php
- Be
- Asset Manifest
- .scratch-mobile-figma-audit.mjs
- @inertiajs/vue3
- Architecture
- psr-4
- keywords
- Per-page breakdown
- graphify reference: extra exports and benchmark
- ClientPolicy
- Sahra Marketing
- ContactSubmissionPolicy
- Implementation Log
- .scratch-navbar.mjs
- FaqPolicy
- postcss
- IndustryPolicy
- @tailwindcss/typography
- MenuPolicy
- @vue/eslint-config-typescript
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
- typescript
- @vitejs/plugin-vue

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

## Communities (229 total, 36 thin omitted)

### Community 0 - "components/chart.js"
Cohesion: 0.01
Nodes (120): acquireContext(), afterDraw(), beforeDatasetDraw(), beforeDatasetsDraw(), beforeDraw(), bh(), Br(), color() (+112 more)

### Community 1 - "rich-editor.js"
Cohesion: 0.02
Nodes (115): activateAttributeIfSupported(), appendStringToTextAtIndex(), applyBlockAttribute(), attachmentDidChangeUploadProgress(), attachmentIsManaged(), attributeChangedCallback(), canRedo(), canUndo() (+107 more)

### Community 2 - "stat/chart.js"
Cohesion: 0.02
Nodes (120): aa(), active(), addControllers(), addPlugins(), addScales(), an(), _animateOptions(), aspectRatio() (+112 more)

### Community 3 - "draw"
Cohesion: 0.04
Nodes (102): ad(), adjustHitBoxes(), ae(), af(), aspectRatio(), C(), calculateLabelRotation(), _computeAngle() (+94 more)

### Community 4 - "a"
Cohesion: 0.08
Nodes (50): e(), i(), l(), Ni(), o(), t(), u(), be() (+42 more)

### Community 5 - "getContext"
Cohesion: 0.06
Nodes (53): acquireContext(), buildTicks(), calculateCircumference(), calculateLabelRotation(), _calculatePadding(), _circumference(), _computeAngle(), _computeGridLineItems() (+45 more)

### Community 6 - "getLength"
Cohesion: 0.04
Nodes (108): addAttribute(), addAttributeAtRange(), addAttributesAtRange(), addHTMLAttribute(), appendText(), applyBlockAttributeAtRange(), breakFormattedBlock(), canBeGroupedWith() (+100 more)

### Community 7 - "_update"
Cohesion: 0.04
Nodes (86): addBox(), afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate() (+78 more)

### Community 8 - "insertString"
Cohesion: 0.05
Nodes (61): attachFiles(), beforeinput(), canApplyToDocument(), compositionend(), compositionstart(), compositionupdate(), createLinkHTML(), dragend() (+53 more)

### Community 9 - "Illuminate\Database\Eloquent\Model"
Cohesion: 0.03
Nodes (44): Client, Faq, Industry, MenuItem, PostCategory, PostTag, ProjectImage, Redirect (+36 more)

### Community 10 - "BasePolicy"
Cohesion: 0.24
Nodes (4): User, BasePolicy, Illuminate\Auth\Access\HandlesAuthorization, Illuminate\Foundation\Auth\User

### Community 11 - "Re"
Cohesion: 0.25
Nodes (41): [x](), Sg(), $c(), ca(), D(), E(), Ea(), g() (+33 more)

### Community 12 - "constructor"
Cohesion: 0.04
Nodes (82): Bl(), cf(), chartOptionScopes(), clone(), constructor(), create(), describe(), Dl() (+74 more)

### Community 13 - "file-upload.js"
Cohesion: 0.04
Nodes (58): ba(), bi(), c(), ca(), clickPercent(), constructor(), define(), e() (+50 more)

### Community 14 - "ManageSettings"
Cohesion: 0.06
Nodes (14): getLabel(), options(), ManageSettings, Tabs, Tabs, Setting, SocialLink, SiteSettings (+6 more)

### Community 15 - "Post"
Cohesion: 0.05
Nodes (13): SitemapController, Menu, Post, Project, ContentTransformer, SectionType, MediaTransformer, NavigationBuilder (+5 more)

### Community 16 - "x"
Cohesion: 0.12
Nodes (70): at(), B(), br(), Bt(), cd(), Cr(), Ct(), dd() (+62 more)

### Community 17 - "Page"
Cohesion: 0.04
Nodes (33): AboutController, AdminLocaleController, ContactController, Controller, HomeController, LeadMagnetDownloadController, LegalController, NewsletterController (+25 more)

### Community 18 - "updateElements"
Cohesion: 0.06
Nodes (56): afterAutoSkip(), Ao(), applyStack(), ar(), as(), Bi(), buildLookupTable(), _calculateBarIndexPixels() (+48 more)

### Community 19 - "getSelectedRange"
Cohesion: 0.07
Nodes (56): attachmentManagerDidRequestRemovalOfAttachment(), breaksOnReturn(), Ca(), canSetCurrentAttribute(), canSetCurrentBlockAttribute(), compositionControllerDidRequestRemovalOfAttachment(), decreaseBlockAttributeLevel(), decreaseListLevel() (+48 more)

### Community 20 - "qt"
Cohesion: 0.04
Nodes (67): Ac(), addEventListener(), alpha(), an(), as(), Au(), ba(), bindResponsiveEvents() (+59 more)

### Community 21 - "te"
Cohesion: 0.05
Nodes (12): Bi(), bn(), Id(), ji(), kd(), on(), qd(), qi() (+4 more)

### Community 22 - "Filament\Resources\Pages\ListRecords"
Cohesion: 0.05
Nodes (18): ListClients, ListContactSubmissions, ListFaqs, ListIndustries, ListMenus, ListNewsletterSubscriptions, ListPages, ListPostCategories (+10 more)

### Community 23 - "select.js"
Cohesion: 0.06
Nodes (24): p(), ce, d(), de, e, ee(), g(), h() (+16 more)

### Community 24 - "ContactSubmissionRequest"
Cohesion: 0.07
Nodes (13): getLabel(), options(), ContactSubmissionRequest, ContactSubmission, ContactSubmissionReceived, Illuminate\Bus\Queueable, Illuminate\Contracts\Queue\ShouldQueue, Illuminate\Database\Eloquent\SoftDeletes (+5 more)

### Community 25 - "St"
Cohesion: 0.06
Nodes (44): alpha(), At(), be(), beforeDraw(), dataset(), ea(), en(), Fa() (+36 more)

### Community 26 - "support.js"
Cohesion: 0.05
Nodes (52): ai(), apply(), B(), co(), Cr(), $e(), es(), Et() (+44 more)

### Community 27 - "markdown-editor.js"
Cohesion: 0.04
Nodes (151): _a(), Aa(), Ae(), af(), ai(), al(), An(), ao() (+143 more)

### Community 28 - "Illuminate\Database\Eloquent\Builder"
Cohesion: 0.03
Nodes (29): getLabel(), options(), Resource, ClientResource, ContactSubmissionResource, FaqResource, IndustryResource, MenuResource (+21 more)

### Community 29 - "ec"
Cohesion: 0.13
Nodes (23): ac(), Ai(), ca(), drawGrid(), ec(), Fc(), G(), getDistanceFromCenterForValue() (+15 more)

### Community 30 - "addEventListener"
Cohesion: 0.17
Nodes (15): Bt(), xo(), addEventListener(), bindResponsiveEvents(), cs(), Ct(), el(), gr() (+7 more)

### Community 31 - "HandlesTranslations.php"
Cohesion: 0.03
Nodes (40): handleRecordCreation(), handleRecordUpdate(), mutateFormDataBeforeCreate(), mutateFormDataBeforeFill(), mutateFormDataBeforeSave(), CreateClient, EditClient, EditContactSubmission (+32 more)

### Community 32 - "draw"
Cohesion: 0.08
Nodes (45): $h(), adjustHitBoxes(), afterDraw(), bc(), Bl(), clear(), _computeLabelArea(), _computeTitleHeight() (+37 more)

### Community 33 - "D"
Cohesion: 0.08
Nodes (40): _a(), al(), ba(), _cachedScopes(), cl(), configure(), createResolver(), D() (+32 more)

### Community 34 - "notifications.js"
Cohesion: 0.08
Nodes (3): duration(), persistent(), seconds()

### Community 35 - "getDatasetMeta"
Cohesion: 0.17
Nodes (18): afterDatasetsUpdate(), generateLabels(), getDatasetMeta(), getDataVisibility(), getMaxBorderWidth(), getStyle(), hide(), isDatasetVisible() (+10 more)

### Community 36 - "_each"
Cohesion: 0.09
Nodes (30): addControllers(), addElements(), addPlugins(), addScales(), buildOrUpdateControllers(), buildOrUpdateElements(), _dataCheck(), _destroy() (+22 more)

### Community 37 - "PageSection"
Cohesion: 0.07
Nodes (14): getLabel(), options(), SectionsRelationManager, PageSection, SectionType, DatabaseSeeder, SectionType, ProjectSeeder (+6 more)

### Community 38 - "deleteInDirection"
Cohesion: 0.07
Nodes (40): ArrowLeft(), ArrowRight(), backspace(), d(), delete(), deleteByComposition(), deleteByCut(), deleteCompositionText() (+32 more)

### Community 39 - "setAttribute"
Cohesion: 0.07
Nodes (52): add(), applyKeyboardCommand(), attachmentDidChangeAttributes(), attachmentEditorDidRequestRemovalOfAttachment(), canBeGrouped(), checkValidity(), copyUsingObjectMap(), copyUsingObjectsFromDocument() (+44 more)

### Community 40 - "AppHeader.vue"
Cohesion: 0.08
Nodes (22): ratios, sources, currentLabel, isCurrent(), page, root, cta, currentLocale (+14 more)

### Community 41 - "fromObject"
Cohesion: 0.04
Nodes (89): _a(), abutsStart(), after(), Ag(), Ai(), before(), daysInMonth(), daysInYear() (+81 more)

### Community 42 - "withTargetDOMRange"
Cohesion: 0.07
Nodes (43): canAcceptDataTransfer(), canDecreaseNestingLevel(), canIncreaseNestingLevel(), compositionControllerDidFocus(), compositionDidRequestChangingSelectionToLocationRange(), createDOMRangeFromLocationRange(), createDOMRangeFromPoint(), createLocationRangeFromDOMRange() (+35 more)

### Community 43 - "Figma ↔ Code Fidelity Audit — SahraMarketing"
Cohesion: 0.05
Nodes (36): Capability gap (read this before the findings), Coverage so far, critical, critical, design-side note, Design-side questions (do not silently conform the code), Figma ↔ Code Fidelity Audit — SahraMarketing, Frame: Home — `1419:9192` (1440 desktop) (+28 more)

### Community 44 - "_update"
Cohesion: 0.07
Nodes (45): afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate(), beforeBuildTicks() (+37 more)

### Community 45 - "compilerOptions"
Cohesion: 0.06
Nodes (35): DOM, DOM.Iterable, ESNext, node, node_modules, public, resources/images/*, resources/js/**/*.d.ts (+27 more)

### Community 46 - "LeadMagnet.vue"
Cohesion: 0.14
Nodes (12): dialog, downloadChecklist(), downloadUrl, form, isComplete, isOpen, LeadMagnetSection, newsletterUrl (+4 more)

### Community 47 - "Vn"
Cohesion: 0.17
Nodes (28): _a(), ba(), Be(), br(), Ca(), ce(), Dn(), ea() (+20 more)

### Community 48 - "cd"
Cohesion: 0.08
Nodes (34): average(), Ca(), cd(), clear(), cn(), Da(), Fc(), fh() (+26 more)

### Community 49 - "Illuminate\Database\Eloquent\Factories\Factory"
Cohesion: 0.09
Nodes (11): ContactSubmissionFactory, NewsletterSubscriptionFactory, PageFactory, static, static, PostFactory, static, ProjectFactory (+3 more)

### Community 50 - "yn"
Cohesion: 0.10
Nodes (26): average(), getBasePosition(), getBaseValue(), getCenterPoint(), getProps(), hasValue(), hs(), inRange() (+18 more)

### Community 51 - "E"
Cohesion: 0.10
Nodes (28): addElements(), beforeUpdate(), bindEvents(), bindUserEvents(), buildOrUpdateControllers(), buildOrUpdateElements(), buildOrUpdateScales(), _checkEventBindings() (+20 more)

### Community 52 - "fn"
Cohesion: 0.16
Nodes (26): Qt(), aa(), da(), fa(), Fi(), fn(), gr(), Ii() (+18 more)

### Community 53 - "get"
Cohesion: 0.05
Nodes (64): aa(), add(), Al(), ar(), bf(), buildTicks(), _cachedScopes(), count() (+56 more)

### Community 54 - "Sahra — Final Figma Parity Verification"
Cohesion: 0.06
Nodes (33): 10. Phase 5 — fixes applied, 11. Live verification (Playwright vs Figma renders), 12. Vertical rhythm retune — home desktop (findings 13–18), 1. Why this cannot be a PASS, 2. Coverage, 3.1 Hardcoded hex distribution, 3. Findings, 4. What actually PASSED (+25 more)

### Community 55 - "serializeSelectionToDataTransfer"
Cohesion: 0.10
Nodes (22): canSetCurrentTextAttribute(), cut(), didClickAttachment(), dragstart(), findAttachmentForElement(), getAttachmentAndPositionById(), getAttachmentById(), getAttachmentPieces() (+14 more)

### Community 56 - "constructor"
Cohesion: 0.07
Nodes (31): box(), canBeConsolidatedWith(), canDecreaseBlockAttributeLevel(), compositionControllerDidRender(), constructor(), formDisabledCallback(), fromUCS2String(), get() (+23 more)

### Community 57 - "constructor"
Cohesion: 0.11
Nodes (20): Yn(), et(), chartOptionScopes(), constructor(), data(), describe(), fl(), Fs() (+12 more)

### Community 58 - "echo.js"
Cohesion: 0.10
Nodes (13): a(), ar(), at(), cr(), d(), f(), H(), ji() (+5 more)

### Community 59 - "notifyEditorElement"
Cohesion: 0.06
Nodes (43): actionIsExternal(), attachmentForFile(), attributesForFile(), canInvokeAction(), compositionControllerDidBlur(), compositionControllerDidSyncDocumentView(), compositionDidAddAttachment(), compositionDidChangeAttachmentPreviewURL() (+35 more)

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
Nodes (39): faqSection, faqSubtitle, hero, heroCtas, heroStack, insights, insightsSubtitle, kpi (+31 more)

### Community 64 - "vue"
Cohesion: 0.10
Nodes (18): vue, glow, horizonSrc, page, component, icons, props, hero (+10 more)

### Community 65 - "useMotion.ts"
Cohesion: 0.12
Nodes (24): setup(), isTallerThanViewport(), MotionTarget, resolve(), useAutoReveal(), useCounters(), useEffectScope(), useHeroStagger() (+16 more)

### Community 66 - "Work/Show.vue"
Cohesion: 0.20
Nodes (8): activeShowcaseIndex, info, intro, pageRoot, props, resultIcons, showcaseFilters, { t }

### Community 67 - "SeoHead.vue"
Cohesion: 0.06
Nodes (28): isArabic, page, PackageItem, articleLd, breadcrumbLd, description, image, locale (+20 more)

### Community 68 - "devDependencies"
Cohesion: 0.09
Nodes (23): autoprefixer, concurrently, eslint, eslint-plugin-vue, laravel-vite-plugin, devDependencies, autoprefixer, concurrently (+15 more)

### Community 69 - "_notify"
Cohesion: 0.20
Nodes (14): active(), _animateOptions(), cancel(), _createAnimations(), _createDescriptors(), _descriptors(), kh(), _notify() (+6 more)

### Community 70 - "A"
Cohesion: 0.43
Nodes (8): oi(), A(), connectedCallback(), disconnectedCallback(), Ge(), required(), setCustomValidity(), setFormValue()

### Community 72 - "dispatch"
Cohesion: 0.25
Nodes (8): dispatch(), dispatchSelf(), dispatchTo(), emit(), emitSelf(), emitTo(), event(), eventData()

### Community 73 - "view"
Cohesion: 0.29
Nodes (7): actions(), button(), constructor(), grouped(), link(), name(), view()

### Community 74 - "T"
Cohesion: 0.14
Nodes (30): Ae(), ar(), at(), Cn(), de(), dt(), En(), fr() (+22 more)

### Community 75 - "Illuminate\Console\Command"
Cohesion: 0.40
Nodes (3): PublishScheduledContent, VerifyAssets, Illuminate\Console\Command

### Community 77 - "appendBlockForElement"
Cohesion: 0.21
Nodes (18): appendAttachmentWithAttributes(), appendBlockForAttributesWithElement(), appendBlockForElement(), appendBlockForTextNode(), appendEmptyBlock(), appendPiece(), appendStringWithAttributes(), findBlockElementAncestors() (+10 more)

### Community 78 - "updateElements"
Cohesion: 0.06
Nodes (53): afterAutoSkip(), Ah(), applyStack(), buildLookupTable(), _calculateBarIndexPixels(), _calculateBarValuePixels(), calculateCircumference(), _calculatePadding() (+45 more)

### Community 79 - "dependencies"
Cohesion: 0.12
Nodes (17): axios, countries-list, gsap, lucide-vue-next, dependencies, axios, countries-list, gsap (+9 more)

### Community 80 - "t"
Cohesion: 0.15
Nodes (14): Ce(), De(), di(), e(), Ht(), Ie(), Me(), Re() (+6 more)

### Community 82 - "render"
Cohesion: 0.08
Nodes (34): cacheViewForObject(), canSyncDocumentView(), compositionDidLoadSnapshot(), createAttachmentNodes(), createChildView(), createContainerElement(), createDocumentFragmentForSync(), createElement() (+26 more)

### Community 83 - "P"
Cohesion: 0.08
Nodes (42): At(), Bi(), Bs(), cc(), Ce(), co(), De(), formats() (+34 more)

### Community 84 - "Contact.vue"
Cohesion: 0.10
Nodes (16): countries, countryOpen, countryPicker, countrySearch, details, filteredCountries, form, page (+8 more)

### Community 85 - "Insights/Show.vue"
Cohesion: 0.17
Nodes (10): ArticlePart, articleParts, copied, linkedInShare, meta, page, props, shareUrl (+2 more)

### Community 86 - "ProjectsShowcase.vue"
Cohesion: 0.10
Nodes (18): activeIndex, activeProject, canRotate, handlePointerUp(), handleVisibilityChange(), isPaused, isVisible, mobileActiveIndex (+10 more)

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
Cohesion: 0.07
Nodes (23): props, { t }, ComponentCustomProperties, Replacements, useTranslations(), vue, basePath, leadRow (+15 more)

### Community 99 - "What You Must Do When Invoked"
Cohesion: 0.08
Nodes (24): For /graphify add and --watch, For /graphify query, For the commit hook and native CLAUDE.md integration, For --update and --cluster-only, /graphify, Honesty Rules, Interpreter guard for subcommands, Part A - Structural extraction for code files (+16 more)

### Community 100 - "ot"
Cohesion: 0.50
Nodes (5): [g](), ot(), rt(), st(), tt()

### Community 102 - "Figma Audit — SahraMarketing"
Cohesion: 0.08
Nodes (23): 1. Frame-set resolution, 2. Design tokens (extracted from Figma variables), 3. Shared component inventory (page `1:2`), 4. Route inventory, 5. Section inventory — Home (`1419:9192`), 6. Animation inventory, 6b. Prototype interactions stored in the file, 7. Form inventory (+15 more)

### Community 103 - "ProcessSection.vue"
Cohesion: 0.40
Nodes (3): iconKeys, ProcessItem, singleAssetIcons

### Community 104 - "config"
Cohesion: 0.22
Nodes (9): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, platform, preferred-install, sort-packages (+1 more)

### Community 105 - "status"
Cohesion: 0.40
Nodes (5): danger(), info(), status(), success(), warning()

### Community 106 - "I"
Cohesion: 0.09
Nodes (40): disabled(), add(), C(), Co(), cr(), diff(), Et(), format() (+32 more)

### Community 107 - "Project.php"
Cohesion: 0.06
Nodes (15): AdminPanelProvider, publish(), scopeDraft(), scopeDuePublication(), scopePublished(), scopeScheduled(), PostSeeder, RolePermissionSeeder (+7 more)

### Community 108 - "Be"
Cohesion: 0.06
Nodes (5): Be, He, oe, pe, te

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
- **493 isolated node(s):** `faOption`, `errors`, `routes`, `results`, `errors` (+488 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **36 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `F()` connect `Re` to `draw`, `rich-editor.js`, `stat/chart.js`, `draw`, `T`, `x`, `color-picker.js`, `support.js`, `ec`, `m`?**
  _High betweenness centrality (0.043) - this node is a cross-community bridge._
- **Why does `draw()` connect `draw` to `components/chart.js`, `A`, `_update`, `Re`, `updateElements`, `cd`, `P`, `qt`, `E`, `m`?**
  _High betweenness centrality (0.041) - this node is a cross-community bridge._
- **Why does `A()` connect `A` to `draw`, `rich-editor.js`, `draw`, `a`, `setAttribute`, `I`, `x`, `getSelectedRange`, `fn`, `select.js`, `constructor`, `markdown-editor.js`, `m`?**
  _High betweenness centrality (0.039) - this node is a cross-community bridge._
- **Are the 13 inferred relationships involving `x()` (e.g. with `de()` and `g()`) actually correct?**
  _`x()` has 13 INFERRED edges - model-reasoned connections that need verification._
- **Are the 19 inferred relationships involving `te()` (e.g. with `je()` and `Pr()`) actually correct?**
  _`te()` has 19 INFERRED edges - model-reasoned connections that need verification._
- **What connects `faOption`, `errors`, `routes` to the rest of the system?**
  _493 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `components/chart.js` be split into smaller, more focused modules?**
  _Cohesion score 0.011213235294117647 - nodes in this community are weakly interconnected._