<x-filament-panels::page>
    <div class="space-y-8 max-w-4xl leading-7">
        <section>
            <h2 class="text-lg font-semibold">{{ __('admin.seo.guide_content.title') }}</h2>
            <p>{{ __('admin.seo.guide_content.intro') }}</p>
        </section>
        @foreach (['settings', 'schema', 'redirects', 'monitor', 'sitemap', 'links'] as $section)
            <section>
                <h2 class="text-lg font-semibold">{{ __("admin.seo.guide_content.{$section}_title") }}</h2>
                <p>{{ __("admin.seo.guide_content.{$section}_body") }}</p>
            </section>
        @endforeach
    </div>
</x-filament-panels::page>
