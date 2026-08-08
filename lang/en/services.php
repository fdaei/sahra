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

    'orbit_label'    => 'Marketing services connected to brand growth',
    'axis_marketing' => 'Marketing',
    'axis_growth'    => 'Growth',
    'core'           => 'Clear Brand Presence',

    'pill_social'    => 'Social Media support',
    'pill_branding'  => 'Branding',
    'pill_content'   => 'Content Production',
    'pill_design'    => 'Marketing Design',

];
