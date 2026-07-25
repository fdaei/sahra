# Traceability Matrix

`Figma node → route → Vue page/component → Laravel model/controller → Filament resource`

Kept in sync with every implementation phase. Status legend:
**F1** foundation · **F2** backbone · **F3** pages · **F4** motion

---

## Pages

| Figma node (desktop / mobile) | Route | Vue page | Controller → Model | Filament resource | Status |
|---|---|---|---|---|---|
| `1419:9192` / `1419:9191` | `/{locale}` | `Pages/Home.vue` | `HomeController` → `Page`,`Project`,`Service`,`Post`,`Testimonial`,`Faq`,`Client` | `PageResource` | F3 |
| `1362:7198` / `1498:10840` | `/{locale}/work` | `Pages/Work/Index.vue` | `ProjectController@index` → `Project` | `ProjectResource` | F3 |
| `1323:7541` / `1555:10866` | `/{locale}/work/{slug}` | `Pages/Work/Show.vue` | `ProjectController@show` → `Project` | `ProjectResource` | F3 |
| `1323:7189` / `1626:12562` | `/{locale}/services` | `Pages/Services.vue` | `ServiceController@index` → `Service` | `ServiceResource` | F3 |
| `908:1576` / `1557:12225` | `/{locale}/about` | `Pages/About.vue` | `AboutController` → `Page`,`TeamMember` | `PageResource`,`TeamMemberResource` | F3 |
| `1353:7935` / `1530:10875` | `/{locale}/insights` | `Pages/Insights/Index.vue` | `PostController@index` → `Post`,`PostCategory` | `PostResource` | F3 |
| `1352:7391` / `1543:11175` | `/{locale}/insights/{slug}` | `Pages/Insights/Show.vue` | `PostController@show` → `Post` | `PostResource` | F3 |
| `1363:8934` / `1494:9544` | `/{locale}/contact` | `Pages/Contact.vue` | `ContactController` → `ContactSubmission` | `ContactSubmissionResource` | F3 |
| `1031:2101` / `1590:10953` | `/{locale}/privacy-policy` | `Pages/Legal.vue` | `LegalController` → `Page` | `PageResource` | F3 |
| `1309:4891` / `1590:11500` | `/{locale}/terms` | `Pages/Legal.vue` | `LegalController` → `Page` | `PageResource` | F3 |
| `1027:2061` / `1567:13563` | fallback | `Pages/NotFound.vue` | — | — | F1 |

## Shared components

| Figma node | Vue component | Data source | Filament | Status |
|---|---|---|---|---|
| `1419:9339` | `Layouts/AppHeader.vue` | `menus`, `settings` | `MenuResource`,`SettingsPage` | F1 |
| `1557:12226` | `Layouts/MobileMenu.vue` | `menus` | `MenuResource` | F1 |
| `1419:9317` | `Layouts/AppFooter.vue` | `menus`,`settings`,`social_links` | `MenuResource`,`SettingsPage` | F1 |
| `158:156` | `Components/BrandLogo.vue` | static SVG asset | — | F1 |
| `1419:9333` | `Components/FinalCtaCard.vue` | `page_sections` global.final_cta | `PageResource` | F1 |
| `1419:9231` | `Components/SectionEyebrow.vue` | prop | — | F1 |
| `1363:7520` | `Components/PageHeading.vue` | prop | — | F1 |
| `1419:9203` | `Components/BaseButton.vue` | prop | — | F1 |
| `1362:7211` | `Components/ProjectCard.vue` | `Project` | `ProjectResource` | F3 |
| `992:2644` | `Components/MemberCard.vue` | `TeamMember` | `TeamMemberResource` | F3 |
| `1419:9251` | `Components/TestimonialCard.vue` | `Testimonial` | `TestimonialResource` | F3 |
| `1061:2072` | `Components/GoalCard.vue` | `SectionItem` | `PageResource` | F3 |
| `1323:7639` | `Components/StrategyCard.vue` | `SectionItem` | `PageResource` | F3 |
| `1419:9295` | `Components/ServiceChip.vue` | `Service` | `ServiceResource` | F3 |
| `1264:3486` | `Components/ServiceSection.vue` | `Service` | `ServiceResource` | F3 |
| `1419:9265` | `Components/InsightCardLarge.vue` | `Post` | `PostResource` | F3 |
| `1419:9267` | `Components/InsightCardSmall.vue` | `Post` | `PostResource` | F3 |
| `1419:9319` | `Components/KpiCounter.vue` | `SectionItem` | `PageResource` | F3 |
| `1419:9310` | `Components/ProcessCard.vue` | `SectionItem` | `PageResource` | F3 |
| `1419:9238` | `Components/WhyUsCard.vue` | `SectionItem` | `PageResource` | F3 |
| `1419:9278` | `Components/FaqAccordion.vue` | `Faq` | `FaqResource` | F3 |
| `1419:9205` | `Components/ClientMarquee.vue` | `Client` | `ClientResource` | F3 |
| `1363:7500` | `Components/FilterChips.vue` | `PostCategory`/`Service` | — | F3 |
| `1323:7576` | `Components/MetaRow.vue` | prop | — | F3 |
| Contact form | `Components/ContactForm.vue` | `ContactSubmission` | `ContactSubmissionResource` | F3 |
| Lead magnet | `Components/NewsletterForm.vue` | `NewsletterSubscription` | `NewsletterSubscriptionResource` | F3 |

## Animations

| ID | Figma evidence | Composable | Status |
|---|---|---|---|
| A1 | `1419:9194` | `useHeroReveal` | F4 |
| A2 | `1419:9215` shade mask | `useMarquee` | F4 |
| A3 | `1419:9318` | `useCounter` | F4 |
| A4 | `1419:9289` orbit rings | `useOrbit` | F4 |
| A5 | note `57:140` | CSS in `ProjectRow.vue` | F4 |
| A6 | `1419:9250` 2452 px track | `useMarquee` | F4 |
| A7 | all section frames | `useSectionReveal` | F4 |
| A8 | `1419:9278` | `FaqAccordion.vue` | F4 |
| A9 | `1530:10879` | `MobileMenu.vue` | F1 |
| A10 | header backdrop-blur | `AppHeader.vue` | F1 |
| A11 | `1419:9333` glow | `useParallax` | F4 |
| A12 | Inertia | `usePageTransition` | F4 |
