{{-- Fallback for Pages/Services.vue. --}}
<section>
    @include('seo.partials.heading', ['heading' => $props['heading'] ?? []])
</section>

<section>
    @include('seo.partials.service-list', ['services' => $props['services'] ?? [], 'level' => 2])
</section>

<x-seo.section :section="$props['sections']['final_cta'] ?? null" />
