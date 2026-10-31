@php
    $sections = $props['sections'] ?? [];
    $settings = $props['settings'] ?? [];
    $heading = $props['heading'] ?? [];
    $heroKey = $component === 'About' ? 'about_hero' : 'hero';
    $hero = $sections[$heroKey] ?? null;
@endphp
<header class="container-sahra py-8">
    <a class="text-title-lg" href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ $settings['siteName'] ?? config('app.name') }}</a>
    <nav aria-label="{{ __('common.primary_navigation') }}">
        <ul class="flex flex-wrap gap-x-8">@include('public.navigation', ['items' => $props['navigation']['header'] ?? []])</ul>
    </nav>
    <nav aria-label="{{ __('common.change_language') }}" class="flex gap-6">
        @foreach ($props['alternates'] ?? [] as $code => $url)
            <a href="{{ $url }}" lang="{{ $code }}" dir="{{ config("locales.supported.{$code}.direction") }}">{{ config("locales.supported.{$code}.native") }}</a>
        @endforeach
    </nav>
</header>
<main id="main" class="container-sahra min-h-screen py-12 leading-loose">
    @if ($component === 'Error')
        <h1 class="text-heading-xl">{{ __('errors.'.($props['status'] ?? 500).'.title') }}</h1>
        <p>{{ __('errors.'.($props['status'] ?? 500).'.message') }}</p>
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('errors.back_home') }}</a>
    @elseif ($component === 'Insights/Show')
        @php($post = $props['post'])
        <article>
            <h1 class="text-heading-xl">{{ $post['title'] }}</h1>
            <p>{{ $post['subtitle'] }}</p>
            <p>{{ $post['excerpt'] }}</p>
            <time datetime="{{ $post['publishedAtIso'] }}">{{ $post['publishedAt'] }}</time>
            @if (!empty($post['author']))<p>{{ __('blog.written_by') }} {{ $post['author']['name'] }}</p>@endif
            @include('public.image', ['image' => $post['image'], 'eager' => true])
            <div class="prose max-w-none">{!! str_replace('[[lead_magnet]]', '', $post['content']) !!}</div>
            @foreach ($post['tags'] as $tag)<span class="me-4">{{ $tag['name'] }}</span>@endforeach
        </article>
        @if (!empty($props['leadMagnet']))@include('public.section', ['section' => $props['leadMagnet']])@endif
        @if ($post['related'])
            <section class="my-16"><h2 class="text-heading-lg">{{ __('blog.related') }}</h2>
                @include('public.cards', ['cards' => $post['related']])
            </section>
        @endif
    @elseif ($component === 'Work/Show')
        @php($project = $props['project'])
        <article>
            <h1 class="text-heading-xl">{{ $project['title'] }}</h1>
            <p>{{ $project['excerpt'] }}</p>
            <dl>
                @foreach (['industry', 'year', 'instagram'] as $key)
                    @if (!empty($project[$key]))<dt>{{ __('work.'.$key) }}</dt><dd>{{ $project[$key] }}</dd>@endif
                @endforeach
                <dt>{{ __('work.services') }}</dt><dd>{{ implode(', ', $project['services']) }}</dd>
            </dl>
            @include('public.image', ['image' => $project['banner'] ?? $project['image'], 'eager' => true])
            <section class="my-16"><h2 class="text-heading-lg">{{ __('work.challenge') }}</h2>
                <p class="whitespace-pre-line">{{ $project['challenge'] }}</p>
                <ul class="list-disc ps-6">@foreach ($project['challengePoints'] as $point)<li>{{ $point }}</li>@endforeach</ul>
            </section>
            @foreach (['goals', 'strategy', 'deliverables'] as $key)
                @if ($project[$key])
                    <section class="my-16"><h2 class="text-heading-lg">{{ __('work.'.$key) }}</h2>
                        @foreach ($project[$key] as $item)
                            <h3 class="text-title-lg">{{ $item['title'] }}</h3><p>{{ $item['description'] }}</p>
                        @endforeach
                    </section>
                @endif
            @endforeach
            <section class="my-16"><h2 class="text-heading-lg">{{ __('work.showcase') }}</h2>
                @foreach ($project['showcase'] as $image)@include('public.image', ['image' => $image])@endforeach
            </section>
            @foreach ($project['beforeAfter'] as $key => $image)
                @if ($image)<h2>{{ __('work.'.$key) }}</h2>@include('public.image', ['image' => $image])@endif
            @endforeach
            <section class="my-16"><h2 class="text-heading-lg">{{ __('work.results') }}</h2>
                <p>{{ $project['resultsSummary'] }}</p>
                <dl>@foreach ($project['results'] as $result)<dt>{{ $result['label'] }}</dt><dd>{{ $result['value'] }}</dd>@endforeach</dl>
            </section>
            @if ($project['next'])<a href="{{ $project['next']['url'] }}">{{ __('work.next_case_study') }}: {{ $project['next']['title'] }}</a>@endif
        </article>
    @elseif ($component === 'Legal')
        <article><h1 class="text-heading-xl">{{ $props['title'] }}</h1><p>{{ $props['subtitle'] }}</p>
            <div class="prose max-w-none">{!! $props['content'] !!}</div>
        </article>
    @else
        @if ($hero)
            @include('public.section', ['section' => $hero, 'level' => 'h1'])
        @else
            <p class="eyebrow">{{ $heading['eyebrow'] ?? '' }}</p>
            <h1 class="text-heading-xl">{{ $heading['title'] ?? $props['seo']['title'] ?? $settings['siteName'] ?? config('app.name') }}</h1>
            <p>{{ $heading['description'] ?? '' }}</p>
        @endif
        @foreach ($sections as $key => $section)
            @if ($key !== $heroKey)@include('public.section', ['section' => $section, 'level' => 'h2'])@endif
        @endforeach
        @if ($component === 'Insights/Index')
            <nav class="my-8 flex flex-wrap gap-6" aria-label="{{ __('blog.categories') }}">
                <a href="{{ route('insights.index') }}">{{ __('common.all') }}</a>
                @foreach ($props['categories'] as $category)
                    <a href="{{ route('insights.index', ['category' => $category['slug']]) }}">{{ $category['name'] }}</a>
                @endforeach
            </nav>
            @include('public.cards', ['cards' => array_merge($props['featured'] ? [$props['featured']] : [], $props['posts']['data'])])
            <nav aria-label="{{ __('common.pagination') }}" class="my-12 flex gap-8">
                @if ($props['posts']['prevPageUrl'])<a href="{{ $props['posts']['prevPageUrl'] }}" rel="prev">{{ __('common.previous') }}</a>@endif
                @if ($props['posts']['nextPageUrl'])<a href="{{ $props['posts']['nextPageUrl'] }}" rel="next">{{ __('common.next') }}</a>@endif
            </nav>
        @else
            @if (!empty($props['projects']))@include('public.cards', ['cards' => $props['projects']])@endif
            @if (!empty($props['posts']))@include('public.cards', ['cards' => $props['posts']])@endif
        @endif
        @if ($component === 'Work/Index')
            <nav class="my-8 flex flex-wrap gap-6">
                <a href="{{ route('work.index') }}">{{ __('common.all') }}</a>
                @foreach ($props['filters'] as $filter)<a href="{{ route('work.index', ['service' => $filter['slug']]) }}">{{ $filter['name'] }}</a>@endforeach
            </nav>
        @endif
        @if (in_array($component, ['Home', 'Services'], true))
            @foreach ($props['services'] as $service)
                <section id="{{ $service['slug'] }}" class="my-16">
                    <h2 class="text-heading-lg">{{ $service['title'] }}</h2><p>{{ $service['description'] }}</p>
                    @include('public.image', ['image' => $service['image']])
                    <ul class="list-disc ps-6">@foreach ($service['features'] as $feature)<li>{{ $feature }}</li>@endforeach</ul>
                    @if ($service['externalUrl'])<a href="{{ $service['externalUrl'] }}">{{ $service['title'] }}</a>@endif
                </section>
            @endforeach
        @endif
        @foreach ($props['team'] ?? [] as $member)
            <article class="my-8"><h2>{{ $member['name'] }}</h2><p>{{ $member['role'] }}</p>@include('public.image', ['image' => $member['image']])</article>
        @endforeach
        @foreach ($props['clients'] ?? [] as $client)
            <figure class="my-8">
                @if ($client['logo'])<img src="{{ $client['logo'] }}" alt="{{ $client['name'] }}" loading="lazy">@endif
                <figcaption>@if ($client['url'])<a href="{{ $client['url'] }}">{{ $client['name'] }}</a>@else{{ $client['name'] }}@endif</figcaption>
            </figure>
        @endforeach
        @foreach ($props['testimonials'] ?? [] as $review)
            <figure class="my-8"><blockquote>{{ $review['quote'] }}</blockquote><figcaption>{{ $review['name'] }} — {{ $review['role'] }}</figcaption></figure>
        @endforeach
        @foreach ($props['faqs'] ?? [] as $faq)
            <details class="my-6"><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>
        @endforeach
        @if ($component === 'Contact')
            @include('public.contact', ['services' => $props['services']])
        @endif
    @endif
    @if (!empty($props['finalCta']))@include('public.section', ['section' => $props['finalCta']])@endif
    @if (session('success'))<p role="status">{{ session('success') }}</p>@endif
</main>
@if ($component !== 'Error')
    <footer class="container-sahra py-12">
        <p>{{ $settings['description'] ?? '' }}</p>
        <ul>@include('public.navigation', ['items' => $props['navigation']['footer'] ?? []])</ul>
        <address>
            @if (!empty($settings['contact']['email']))<a href="mailto:{{ $settings['contact']['email'] }}">{{ $settings['contact']['email'] }}</a>@endif
            @if (!empty($settings['contact']['phone']))<a href="tel:{{ $settings['contact']['phone'] }}">{{ $settings['contact']['phone'] }}</a>@endif
            <p>{{ $settings['contact']['location'] ?? '' }}</p><p>{{ $settings['contact']['workingWith'] ?? '' }}</p>
        </address>
        <ul>@foreach ($settings['socialLinks'] ?? [] as $link)<li><a href="{{ $link['url'] }}">{{ $link['platform'] }}</a></li>@endforeach</ul>
    </footer>
@endif
