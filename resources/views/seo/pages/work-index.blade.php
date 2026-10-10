{{-- Fallback for Pages/Work/Index.vue. --}}
<section>
    @include('seo.partials.heading', ['heading' => $props['heading'] ?? []])
    @include('seo.partials.project-list', ['projects' => $props['projects'] ?? [], 'level' => 2])
</section>

<x-seo.section :section="$props['sections']['final_cta'] ?? null" />
