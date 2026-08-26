<?php

declare(strict_types=1);

/*
 | Static chrome for the services orbit (Figma 1419:9279 / 1323:7189).
 |
 | The section heading, body and pill labels are authored content and arrive
 | from the database. The strings here are the surrounding furniture plus the
 | fallbacks used when a service row has not been authored for the active
 | locale — previously hardcoded English in ServicesOrbit.vue, which rendered
 | Latin text inside the fa/ar pages.
 */
return [

    'eyebrow'        => 'Our Services',

    'orbit_label'    => 'Brand and product services meeting in mastery',
    'venn_brand'     => 'Brand',
    'venn_product'   => 'Product',
    'core'           => 'Service Mastery',

    'pill_social'    => 'Social Media support',
    'pill_branding'  => 'Branding',
    'pill_content'   => 'Content Production',
    'pill_design'    => 'Marketing Design',

    /*
     | Decorative only — the burst reveal's ghost tags either side of the
     | Venn, gesturing at the breadth of a full-service agency. Not backed by
     | a service row, never linked, aria-hidden in the markup.
     */
    'ghost_copywriting'     => 'Copywriting',
    'ghost_market_research' => 'Market Research',
    'ghost_pr_media'        => 'PR & Media',
    'ghost_seo'             => 'SEO',
    'ghost_email_marketing' => 'Email Marketing',
    'ghost_analytics'       => 'Analytics',

];
