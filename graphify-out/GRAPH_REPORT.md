# Graph Report - sahra  (2026-08-09)

## Corpus Check
- 353 files · ~1,549,018 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 4829 nodes · 12398 edges · 219 communities (195 shown, 24 thin omitted)
- Extraction: 90% EXTRACTED · 10% INFERRED · 0% AMBIGUOUS · INFERRED: 1180 edges (avg confidence: 0.68)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `defe9260`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- components/chart.js
- rich-editor.js
- stat/chart.js
- draw
- markdown-editor.js
- fromObject
- locationFromPosition
- _update
- insertString
- Illuminate\Database\Eloquent\Model
- BasePolicy
- vd
- constructor
- file-upload.js
- MenuItem
- Post
- x
- Page
- T
- getSelectedRange
- qt
- te
- Filament\Resources\Pages\ListRecords
- select.js
- ContactSubmission
- Section
- support.js
- getContext
- Illuminate\Database\Eloquent\Builder
- Filament\Resources\Pages\EditRecord
- I
- HandlesTranslations.php
- draw
- getOptionScopes
- notifications.js
- getDatasetMeta
- notifyEditorElement
- Project
- ImagesRelationManager.php
- setAttribute
- AppFooter.vue
- parse
- getLocationRange
- Figma ↔ Code Fidelity Audit — SahraMarketing
- _update
- compilerOptions
- splice
- Vn
- cd
- Illuminate\Database\Eloquent\Factories\Factory
- St
- f
- fn
- buildTicks
- Sahra — Final Figma Parity Verification
- C
- constructor
- deleteInDirection
- echo.js
- render
- getDatasetMeta
- Illuminate\Database\Seeder
- m
- Home.vue
- index.ts
- useMotion.ts
- Faq
- Insights/Index.vue
- devDependencies
- _each
- SeoHead.vue
- .parent
- Qe
- ManageSettings
- qe
- Illuminate\Http\Request
- PageSeeder
- appendBlockForElement
- updateElements
- dependencies
- t
- color-picker.js
- W
- Ms
- vue
- Insights/Show.vue
- ProjectsShowcase.vue
- composer.json
- scripts
- scripts
- app.js
- r
- Fe
- AppServiceProvider
- require
- require-dev
- ServicesOrbit.vue
- useTranslations.ts
- Work/Index.vue
- What You Must Do When Invoked
- qt
- ContactSubmissionResource
- Figma Audit — SahraMarketing
- preload
- config
- yn
- br
- PublicationStatus.php
- de
- Asset Manifest
- He
- serializeSelectionToDataTransfer
- pe
- Architecture
- psr-4
- keywords
- Per-page breakdown
- graphify reference: extra exports and benchmark
- post-autoload-dump
- Sahra Marketing
- TestCase.php
- a
- Implementation Log
- .scratch-navbar.mjs
- @inertiajs/vue3
- laravel-vite-plugin
- postcss
- @tailwindcss/forms
- @tailwindcss/typography
- @types/node
- @vue/eslint-config-typescript
- vue-tsc
- .scratch-locale-persist.mjs
- fetch-fonts.sh
- responsive.spec.ts
- NewsletterSubscriptionResource
- graphify reference: query, path, explain
- TestimonialResource
- Traceability Matrix
- graphify reference: add a URL and watch a folder
- graphify reference: commit hook and native CLAUDE.md integration
- graphify reference: incremental update and cluster-only
- Content TODO — real assets and copy still needed
- graphify reference: GitHub clone and cross-repo merge
- graphify reference: transcribe video and audio
- graphify
- extraction-spec.md

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
- `constructor()` --indirect_call--> `Yn()`  [INFERRED]
  public/js/filament/widgets/components/stats-overview/stat/chart.js → public/js/filament/filament/echo.js
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

## Communities (219 total, 24 thin omitted)

### Community 0 - "components/chart.js"
Cohesion: 0.01
Nodes (109): abutsStart(), acquireContext(), addControllers(), addPlugins(), addScales(), alpha(), beforeDatasetDraw(), beforeDatasetsDraw() (+101 more)

### Community 1 - "rich-editor.js"
Cohesion: 0.02
Nodes (129): activateAttributeIfSupported(), appendStringToTextAtIndex(), applyBlockAttribute(), attachmentDidChangeUploadProgress(), attachmentIsManaged(), attributeChangedCallback(), canRedo(), canUndo() (+121 more)

### Community 2 - "stat/chart.js"
Cohesion: 0.02
Nodes (120): aa(), active(), alpha(), an(), _animateOptions(), be(), beforeDatasetDraw(), beforeDatasetsDraw() (+112 more)

### Community 3 - "draw"
Cohesion: 0.04
Nodes (110): ad(), adjustHitBoxes(), ae(), af(), aspectRatio(), C(), calculateLabelRotation(), _calculatePadding() (+102 more)

### Community 4 - "markdown-editor.js"
Cohesion: 0.04
Nodes (140): Aa(), Ac(), af(), al(), An(), ao(), Be(), bf() (+132 more)

### Community 5 - "fromObject"
Cohesion: 0.03
Nodes (108): _a(), after(), afterAutoSkip(), Ai(), Al(), as(), before(), buildLookupTable() (+100 more)

### Community 6 - "locationFromPosition"
Cohesion: 0.04
Nodes (96): addAttribute(), addAttributeAtRange(), addAttributesAtRange(), addHTMLAttribute(), appendText(), applyBlockAttributeAtRange(), canBeGroupedWith(), canDecreaseBlockAttributeLevel() (+88 more)

### Community 7 - "_update"
Cohesion: 0.03
Nodes (114): add(), addBox(), afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterDraw(), afterFit(), afterSetDimensions() (+106 more)

### Community 8 - "insertString"
Cohesion: 0.04
Nodes (68): attachFiles(), canApplyToDocument(), compositionend(), compositionstart(), compositionupdate(), createLinkHTML(), deleteByDrag(), dragend() (+60 more)

### Community 9 - "Illuminate\Database\Eloquent\Model"
Cohesion: 0.05
Nodes (33): Industry, PostTag, ProjectImage, Redirect, ClientTranslation, FaqTranslation, IndustryTranslation, MenuItemTranslation (+25 more)

### Community 10 - "BasePolicy"
Cohesion: 0.03
Nodes (29): User, BasePolicy, ClientPolicy, ContactSubmissionPolicy, FaqPolicy, IndustryPolicy, MenuPolicy, NewsletterSubscriptionPolicy (+21 more)

### Community 11 - "vd"
Cohesion: 0.09
Nodes (53): _a(), Ae(), ai(), ar(), Ba(), ci(), da(), fa() (+45 more)

### Community 12 - "constructor"
Cohesion: 0.04
Nodes (81): Bl(), cf(), clone(), constructor(), create(), Dl(), dtFormatter(), Ec() (+73 more)

### Community 13 - "file-upload.js"
Cohesion: 0.04
Nodes (75): e(), i(), l(), Ni(), o(), t(), u(), ba() (+67 more)

### Community 14 - "MenuItem"
Cohesion: 0.06
Nodes (9): getLabel(), options(), Menu, MenuItem, Setting, SocialLink, NavigationBuilder, SiteSettings (+1 more)

### Community 15 - "Post"
Cohesion: 0.05
Nodes (11): SitemapController, Post, SectionItem, ContentTransformer, SectionType, MediaTransformer, Numerals, Illuminate\Database\Eloquent\Relations\BelongsTo (+3 more)

### Community 16 - "x"
Cohesion: 0.14
Nodes (64): as(), at(), B(), br(), Bt(), ca(), cd(), Cr() (+56 more)

### Community 17 - "Page"
Cohesion: 0.06
Nodes (17): AboutController, AdminLocaleController, ContactController, Controller, HomeController, LegalController, PostController, ProjectController (+9 more)

### Community 18 - "T"
Cohesion: 0.07
Nodes (50): xg(), ac(), Ai(), applyStack(), ar(), as(), aspectRatio(), ca() (+42 more)

### Community 19 - "getSelectedRange"
Cohesion: 0.06
Nodes (60): breakFormattedBlock(), breaksOnReturn(), Ca(), canSetCurrentAttribute(), canSetCurrentBlockAttribute(), copyWithoutText(), decreaseBlockAttributeLevel(), decreaseListLevel() (+52 more)

### Community 20 - "qt"
Cohesion: 0.07
Nodes (35): addEventListener(), bindEvents(), bindResponsiveEvents(), bindUserEvents(), ch(), _checkEventBindings(), cu(), dataset() (+27 more)

### Community 21 - "te"
Cohesion: 0.05
Nodes (9): Bi(), bn(), Id(), ji(), kd(), qi(), Ri(), te() (+1 more)

### Community 22 - "Filament\Resources\Pages\ListRecords"
Cohesion: 0.05
Nodes (18): ListClients, ListContactSubmissions, ListFaqs, ListIndustries, ListMenus, ListNewsletterSubscriptions, ListPages, ListPostCategories (+10 more)

### Community 23 - "select.js"
Cohesion: 0.07
Nodes (67): [g](), [x](), $c(), D(), E(), Ea(), g(), H() (+59 more)

### Community 24 - "ContactSubmission"
Cohesion: 0.07
Nodes (14): NewsletterController, ContactSubmissionRequest, NewsletterSubscriptionRequest, ContactSubmission, NewsletterSubscription, ContactSubmissionReceived, SubmissionHandler, Illuminate\Bus\Queueable (+6 more)

### Community 25 - "Section"
Cohesion: 0.07
Nodes (7): MenuResource, PageResource, PostResource, ProjectResource, ServiceResource, PublicationFields, Section

### Community 26 - "support.js"
Cohesion: 0.06
Nodes (40): ai(), apply(), B(), co(), Cr(), $e(), es(), Et() (+32 more)

### Community 27 - "getContext"
Cohesion: 0.07
Nodes (54): acquireContext(), calculateLabelRotation(), _calculatePadding(), _computeAngle(), _computeGridLineItems(), _computeLabelItems(), computeTickLimit(), _drawArgs() (+46 more)

### Community 28 - "Illuminate\Database\Eloquent\Builder"
Cohesion: 0.10
Nodes (16): Resource, FaqResource, PostTagResource, RedirectResource, SocialLinkResource, UserResource, scopeDraft(), scopeDuePublication() (+8 more)

### Community 29 - "Filament\Resources\Pages\EditRecord"
Cohesion: 0.05
Nodes (17): EditClient, EditContactSubmission, EditFaq, EditIndustry, EditMenu, EditPage, EditPostCategory, EditPost (+9 more)

### Community 30 - "I"
Cohesion: 0.05
Nodes (56): addEventListener(), bindEvents(), bindResponsiveEvents(), bindUserEvents(), buildOrUpdateScales(), cl(), _computeLabelSizes(), cs() (+48 more)

### Community 31 - "HandlesTranslations.php"
Cohesion: 0.06
Nodes (22): handleRecordCreation(), handleRecordUpdate(), mutateFormDataBeforeCreate(), mutateFormDataBeforeFill(), mutateFormDataBeforeSave(), CreateClient, CreateFaq, CreateIndustry (+14 more)

### Community 32 - "draw"
Cohesion: 0.08
Nodes (43): adjustHitBoxes(), afterDraw(), bc(), Bl(), clear(), _computeLabelArea(), _computeTitleHeight(), _createItems() (+35 more)

### Community 33 - "getOptionScopes"
Cohesion: 0.08
Nodes (33): _a(), al(), ba(), _cachedScopes(), createResolver(), datasetElementScopeKeys(), fn(), get() (+25 more)

### Community 34 - "notifications.js"
Cohesion: 0.06
Nodes (23): actions(), button(), constructor(), danger(), dispatch(), dispatchSelf(), dispatchTo(), duration() (+15 more)

### Community 35 - "getDatasetMeta"
Cohesion: 0.06
Nodes (50): addElements(), afterDatasetsUpdate(), buildOrUpdateControllers(), buildOrUpdateElements(), _checkEventBindings(), configure(), _dataCheck(), datasetAnimationScopeKeys() (+42 more)

### Community 36 - "notifyEditorElement"
Cohesion: 0.14
Nodes (18): actionIsExternal(), canInvokeAction(), compositionControllerDidBlur(), compositionControllerDidSyncDocumentView(), compositionDidAddAttachment(), compositionDidChangeAttachmentPreviewURL(), compositionDidChangeCurrentAttributes(), compositionDidEditAttachment() (+10 more)

### Community 37 - "Project"
Cohesion: 0.07
Nodes (11): getLabel(), options(), SectionsRelationManager, PageSection, SectionType, Project, SectionType, ProjectSeeder (+3 more)

### Community 38 - "ImagesRelationManager.php"
Cohesion: 0.24
Nodes (3): ItemsRelationManager, ImagesRelationManager, Filament\Resources\RelationManagers\RelationManager

### Community 39 - "setAttribute"
Cohesion: 0.08
Nodes (44): add(), applyKeyboardCommand(), attachmentDidChangeAttributes(), attachmentEditorDidRequestRemovalOfAttachment(), canBeGrouped(), checkValidity(), createCaptionElement(), createContentNodes() (+36 more)

### Community 40 - "AppFooter.vue"
Cohesion: 0.06
Nodes (32): ratios, sources, currentLabel, isCurrent(), page, root, columns, footerFont (+24 more)

### Community 41 - "parse"
Cohesion: 0.09
Nodes (35): addElements(), buildOrUpdateElements(), Ca(), Ce(), co(), _dataCheck(), _destroy(), formats() (+27 more)

### Community 42 - "getLocationRange"
Cohesion: 0.09
Nodes (33): canAcceptDataTransfer(), canDecreaseNestingLevel(), canIncreaseNestingLevel(), compositionControllerDidFocus(), compositionDidRequestChangingSelectionToLocationRange(), createDOMRangeFromPoint(), createLocationRangeFromDOMRange(), decreaseNestingLevel() (+25 more)

### Community 43 - "Figma ↔ Code Fidelity Audit — SahraMarketing"
Cohesion: 0.05
Nodes (36): Capability gap (read this before the findings), Coverage so far, critical, critical, design-side note, Design-side questions (do not silently conform the code), Figma ↔ Code Fidelity Audit — SahraMarketing, Frame: Home — `1419:9192` (1440 desktop) (+28 more)

### Community 44 - "_update"
Cohesion: 0.08
Nodes (39): afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate(), beforeBuildTicks() (+31 more)

### Community 45 - "compilerOptions"
Cohesion: 0.06
Nodes (35): DOM, DOM.Iterable, ESNext, node, node_modules, public, resources/images/*, resources/js/**/*.d.ts (+27 more)

### Community 46 - "splice"
Cohesion: 0.14
Nodes (16): consolidateFromIndexToIndex(), findIndexAndOffsetAtPosition(), getObjectAtIndex(), getObjectAtPosition(), getSplittableListInRange(), insertObjectAtIndex(), insertSplittableListAtIndex(), insertSplittableListAtPosition() (+8 more)

### Community 47 - "Vn"
Cohesion: 0.17
Nodes (32): _a(), aa(), ba(), Be(), br(), Ca(), ce(), Dn() (+24 more)

### Community 48 - "cd"
Cohesion: 0.06
Nodes (42): active(), _animateOptions(), average(), cd(), clear(), cn(), _createAnimations(), Da() (+34 more)

### Community 49 - "Illuminate\Database\Eloquent\Factories\Factory"
Cohesion: 0.08
Nodes (11): getLabel(), options(), ContactSubmissionFactory, NewsletterSubscriptionFactory, PageFactory, static, static, ProjectFactory (+3 more)

### Community 50 - "St"
Cohesion: 0.10
Nodes (28): At(), average(), beforeDraw(), dataset(), Fa(), getCenterPoint(), getMaximumSize(), getProps() (+20 more)

### Community 51 - "f"
Cohesion: 0.33
Nodes (11): dd(), f(), Jl(), lr(), md(), ot(), rd(), uf() (+3 more)

### Community 52 - "fn"
Cohesion: 0.14
Nodes (30): Qt(), Cn(), da(), En(), fa(), Fi(), fn(), h() (+22 more)

### Community 53 - "buildTicks"
Cohesion: 0.11
Nodes (24): aa(), ar(), bf(), buildTicks(), determineDataLimits(), Dh(), _generate(), _getLabelBounds() (+16 more)

### Community 54 - "Sahra — Final Figma Parity Verification"
Cohesion: 0.06
Nodes (33): 10. Phase 5 — fixes applied, 11. Live verification (Playwright vs Figma renders), 12. Vertical rhythm retune — home desktop (findings 13–18), 1. Why this cannot be a PASS, 2. Coverage, 3.1 Hardcoded hex distribution, 3. Findings, 4. What actually PASSED (+25 more)

### Community 55 - "C"
Cohesion: 0.06
Nodes (61): add(), afterAutoSkip(), Ao(), Bi(), buildLookupTable(), buildTicks(), C(), Co() (+53 more)

### Community 56 - "constructor"
Cohesion: 0.10
Nodes (22): box(), canBeConsolidatedWith(), compositionControllerDidRender(), constructor(), formDisabledCallback(), fromUCS2String(), get(), getLevel() (+14 more)

### Community 57 - "deleteInDirection"
Cohesion: 0.07
Nodes (39): ArrowLeft(), ArrowRight(), attachmentManagerDidRequestRemovalOfAttachment(), backspace(), compositionControllerDidRequestRemovalOfAttachment(), d(), delete(), deleteByComposition() (+31 more)

### Community 58 - "echo.js"
Cohesion: 0.10
Nodes (11): ar(), b(), cr(), g(), Me(), P(), Pr(), qt() (+3 more)

### Community 59 - "render"
Cohesion: 0.06
Nodes (41): beforeinput(), cacheViewForObject(), canSyncDocumentView(), compositionDidChangeDocument(), compositionDidLoadSnapshot(), createAttachmentNodes(), createChildView(), createContainerElement() (+33 more)

### Community 60 - "getDatasetMeta"
Cohesion: 0.10
Nodes (30): afterDatasetsUpdate(), buildOrUpdateControllers(), _d(), _destroyDatasetMeta(), generateLabels(), getDatasetMeta(), getDataVisibility(), getMaxBorderWidth() (+22 more)

### Community 61 - "Illuminate\Database\Seeder"
Cohesion: 0.14
Nodes (6): PostCategory, DatabaseSeeder, PostSeeder, ServiceSeeder, TaxonomySeeder, Illuminate\Database\Seeder

### Community 62 - "m"
Cohesion: 0.22
Nodes (26): Bi(), d(), Di(), f(), Ge(), I(), ir(), ja() (+18 more)

### Community 63 - "Home.vue"
Cohesion: 0.08
Nodes (22): PackageItem, iconKeys, ProcessItem, singleAssetIcons, faqSection, hero, heroStack, insights (+14 more)

### Community 64 - "index.ts"
Cohesion: 0.08
Nodes (27): hero, heroImage, howWeThink, props, SectionContent, story, team, SectionContent (+19 more)

### Community 65 - "useMotion.ts"
Cohesion: 0.12
Nodes (24): glow, horizonSrc, page, MotionTarget, resolve(), useCounters(), useEffectScope(), useHeroStagger() (+16 more)

### Community 66 - "Faq"
Cohesion: 0.12
Nodes (4): Faq, TeamMember, Testimonial, ContentSeeder

### Community 67 - "Insights/Index.vue"
Cohesion: 0.15
Nodes (9): props, { t }, basePath, leadRow, page, props, restRows, SectionContent (+1 more)

### Community 68 - "devDependencies"
Cohesion: 0.10
Nodes (21): autoprefixer, concurrently, eslint, eslint-plugin-vue, devDependencies, autoprefixer, concurrently, eslint (+13 more)

### Community 69 - "_each"
Cohesion: 0.08
Nodes (31): addControllers(), addPlugins(), addScales(), cancel(), _createDescriptors(), _descriptors(), dl(), Do() (+23 more)

### Community 70 - "SeoHead.vue"
Cohesion: 0.18
Nodes (10): articleLd, breadcrumbLd, description, image, locale, organizationLd, page, props (+2 more)

### Community 71 - ".parent"
Cohesion: 0.07
Nodes (6): ClientResource, ViewContactSubmission, IndustryResource, PostCategoryResource, TeamMemberResource, Filament\Resources\Pages\ViewRecord

### Community 72 - "Qe"
Cohesion: 0.08
Nodes (30): Ag(), Ef(), fe(), features(), fromFormat(), fromHTTP(), fromRFC2822(), fromSQL() (+22 more)

### Community 73 - "ManageSettings"
Cohesion: 0.16
Nodes (8): ManageSettings, Tabs, Tabs, Filament\Forms\Components\Tabs, Filament\Forms\Concerns\InteractsWithForms, Filament\Forms\Contracts\HasForms, Filament\Notifications\Notification, Filament\Pages\Page

### Community 74 - "qe"
Cohesion: 0.23
Nodes (18): Ae(), at(), de(), dt(), fr(), Gt(), ht(), It() (+10 more)

### Community 75 - "Illuminate\Http\Request"
Cohesion: 0.15
Nodes (11): HandleInertiaRequests, RedirectToLocalisedRoute, SetAdminLocale, SetLocale, LocaleAlternates, Carbon\Carbon, Closure, Illuminate\Foundation\Configuration\Middleware (+3 more)

### Community 77 - "appendBlockForElement"
Cohesion: 0.18
Nodes (20): It(), appendAttachmentWithAttributes(), appendBlockForAttributesWithElement(), appendBlockForElement(), appendBlockForTextNode(), appendEmptyBlock(), appendPiece(), appendStringWithAttributes() (+12 more)

### Community 78 - "updateElements"
Cohesion: 0.11
Nodes (30): applyStack(), _calculateBarIndexPixels(), _calculateBarValuePixels(), calculateCircumference(), _circumference(), countVisibleElements(), fa(), getBasePixel() (+22 more)

### Community 79 - "dependencies"
Cohesion: 0.13
Nodes (15): axios, gsap, lucide-vue-next, dependencies, axios, gsap, lucide-vue-next, swiper (+7 more)

### Community 80 - "t"
Cohesion: 0.21
Nodes (11): di(), e(), Ht(), i(), Ie(), Mt(), Re(), t() (+3 more)

### Community 82 - "W"
Cohesion: 0.09
Nodes (29): Ah(), At(), Bi(), Bs(), cc(), De(), describe(), Ea() (+21 more)

### Community 83 - "Ms"
Cohesion: 0.09
Nodes (28): Ac(), an(), Au(), ba(), bu(), Dc(), eo(), fo() (+20 more)

### Community 84 - "vue"
Cohesion: 0.15
Nodes (11): vue, component, icons, props, details, form, page, SectionContent (+3 more)

### Community 85 - "Insights/Show.vue"
Cohesion: 0.14
Nodes (11): LeadMagnetSection, ArticlePart, articleParts, copied, linkedInShare, meta, page, props (+3 more)

### Community 86 - "ProjectsShowcase.vue"
Cohesion: 0.16
Nodes (12): activeIndex, activeProject, canRotate, handleVisibilityChange(), isPaused, isVisible, props, SectionContent (+4 more)

### Community 87 - "composer.json"
Cohesion: 0.15
Nodes (12): autoload-dev, psr-4, description, extra, laravel, dont-discover, license, minimum-stability (+4 more)

### Community 88 - "scripts"
Cohesion: 0.15
Nodes (13): scripts, dev, post-create-project-cmd, post-root-package-install, post-update-cmd, test, Composer\\Config::disableProcessTimeout, npx concurrently -c \"#93c5fd,#c4b5fd,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1\" \"npm run dev\" --names=server,queue,vite (+5 more)

### Community 89 - "scripts"
Cohesion: 0.17
Nodes (11): name, private, scripts, build, dev, format, lint, test:e2e (+3 more)

### Community 90 - "app.js"
Cohesion: 0.26
Nodes (7): C(), D(), J(), O(), U(), v(), X()

### Community 91 - "r"
Cohesion: 0.18
Nodes (12): Be(), ei(), ii(), le(), ni(), oi(), r(), ri() (+4 more)

### Community 92 - "Fe"
Cohesion: 0.22
Nodes (9): Ce(), De(), Dt(), Fe(), He(), ir(), nr(), rt() (+1 more)

### Community 93 - "AppServiceProvider"
Cohesion: 0.28
Nodes (4): AppServiceProvider, Illuminate\Support\ServiceProvider, vite, vite

### Community 94 - "require"
Cohesion: 0.22
Nodes (9): require, filament/filament, inertiajs/inertia-laravel, laravel/framework, laravel/tinker, php, spatie/laravel-permission, spatie/laravel-sitemap (+1 more)

### Community 95 - "require-dev"
Cohesion: 0.22
Nodes (9): require-dev, fakerphp/faker, laravel/pail, laravel/pint, laravel/sail, mockery/mockery, nunomaduro/collision, pestphp/pest (+1 more)

### Community 96 - "ServicesOrbit.vue"
Cohesion: 0.31
Nodes (8): innerRing, outerRing, pills, props, serviceFor(), serviceLabel(), ServiceSection, { t }

### Community 97 - "useTranslations.ts"
Cohesion: 0.09
Nodes (19): setup(), ComponentCustomProperties, installTranslations(), Replacements, useTranslations(), vue, homeUrl, key (+11 more)

### Community 98 - "Work/Index.vue"
Cohesion: 0.22
Nodes (8): basePath, hasMore, page, props, SectionContent, shown, { t }, visibleProjects

### Community 99 - "What You Must Do When Invoked"
Cohesion: 0.08
Nodes (24): For /graphify add and --watch, For /graphify query, For the commit hook and native CLAUDE.md integration, For --update and --cluster-only, /graphify, Honesty Rules, Interpreter guard for subcommands, Part A - Structural extraction for code files (+16 more)

### Community 100 - "qt"
Cohesion: 0.36
Nodes (8): hs(), Ln(), Nn(), ps(), qt(), Ro(), Se(), wo()

### Community 102 - "Figma Audit — SahraMarketing"
Cohesion: 0.08
Nodes (23): 1. Frame-set resolution, 2. Design tokens (extracted from Figma variables), 3. Shared component inventory (page `1:2`), 4. Route inventory, 5. Section inventory — Home (`1419:9192`), 6. Animation inventory, 6b. Prototype interactions stored in the file, 7. Form inventory (+15 more)

### Community 103 - "preload"
Cohesion: 0.10
Nodes (23): attachmentForFile(), attributesForFile(), compositionShouldAcceptFile(), didChangeAttributes(), getContentType(), getCurrentTextAttributes(), getHeight(), getHref() (+15 more)

### Community 104 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 105 - "yn"
Cohesion: 0.33
Nodes (7): ar(), ft(), kn(), sr(), wn(), Ye(), yn()

### Community 106 - "br"
Cohesion: 0.29
Nodes (7): chartOptionScopes(), br(), ii(), vr(), xr(), Xs(), yr()

### Community 107 - "PublicationStatus.php"
Cohesion: 0.06
Nodes (9): PublishScheduledContent, VerifyAssets, getLabel(), options(), publish(), static, PostFactory, Illuminate\Console\Command (+1 more)

### Community 108 - "de"
Cohesion: 0.06
Nodes (5): Be, de, le, oe, te

### Community 109 - "Asset Manifest"
Cohesion: 0.11
Nodes (17): 0. Bulk export (do this first), 10. Fonts — ACTION REQUIRED, 10b. Exported via the REST API, 11. Export-completeness checklist, 1. Branding, 2. Home page, 3. Client logos (trust proof strip), 4. Projects (+9 more)

### Community 111 - "serializeSelectionToDataTransfer"
Cohesion: 0.12
Nodes (18): canSetCurrentTextAttribute(), cut(), didClickAttachment(), dragstart(), findAttachmentForElement(), getAttachmentAndPositionById(), getAttachmentById(), getAttachmentPieces() (+10 more)

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

### Community 118 - "post-autoload-dump"
Cohesion: 0.50
Nodes (4): post-autoload-dump, Illuminate\\Foundation\\ComposerScripts::postAutoloadDump, @php artisan filament:upgrade, @php artisan package:discover --ansi

### Community 119 - "Sahra Marketing"
Cohesion: 0.22
Nodes (8): 1. Requirements, 2. Installation, 3. Running locally, 4. Testing, 5. Production build & deployment, 6. Project structure, 7. Known limitations, Sahra Marketing

### Community 129 - "a"
Cohesion: 0.25
Nodes (8): a(), at(), d(), f(), H(), ji(), L(), pt()

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
- **442 isolated node(s):** `faOption`, `errors`, `workLink`, `name`, `type` (+437 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **24 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Br()` connect `components/chart.js` to `fromObject`, `setAttribute`, `t`, `x`, `constructor`?**
  _High betweenness centrality (0.043) - this node is a cross-community bridge._
- **Why does `F()` connect `select.js` to `draw`, `rich-editor.js`, `stat/chart.js`, `draw`, `qe`, `x`, `color-picker.js`, `support.js`, `getContext`, `m`?**
  _High betweenness centrality (0.041) - this node is a cross-community bridge._
- **Why does `draw()` connect `draw` to `components/chart.js`, `_update`, `parse`, `vd`, `updateElements`, `cd`, `Ms`, `qt`, `I`, `select.js`, `m`?**
  _High betweenness centrality (0.041) - this node is a cross-community bridge._
- **Are the 13 inferred relationships involving `x()` (e.g. with `de()` and `g()`) actually correct?**
  _`x()` has 13 INFERRED edges - model-reasoned connections that need verification._
- **Are the 19 inferred relationships involving `te()` (e.g. with `je()` and `Pr()`) actually correct?**
  _`te()` has 19 INFERRED edges - model-reasoned connections that need verification._
- **What connects `faOption`, `errors`, `workLink` to the rest of the system?**
  _442 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `components/chart.js` be split into smaller, more focused modules?**
  _Cohesion score 0.011441953830712613 - nodes in this community are weakly interconnected._