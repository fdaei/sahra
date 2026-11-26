@php
    $basePath = route('insights.index', absolute: false);
    $filterItems = \App\Support\PublicPage::categoryFilters($categories, $filters['category']);
    $leadRow = array_slice($posts['data'], 0, 2);
    $restRows = array_slice($posts['data'], 2);
@endphp

<div class="container-sahra flex flex-col gap-16 pb-0 pt-[160px] md:gap-24 md:pb-32 md:pt-[192px]">
    <div class="flex flex-col gap-16 lg:flex-row lg:items-start lg:justify-between">
        <div class="flex h-[184px] max-w-[612px] flex-col gap-6 md:h-auto md:gap-12">
            <p class="eyebrow">{{ $heading['eyebrow'] }}</p>
            <div class="flex flex-col gap-6">
                <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">{{ $heading['title'] }}</h1>
                <p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">{{ $heading['description'] }}</p>
            </div>
        </div>
        @if ((count($categories) > 0))
            @includeIsolated('public.components.filter-chips', ['paramName' => 'category', 'items' => $filterItems, 'active' => $filters['category'], 'basePath' => $basePath, 'extraParams' => ['q' => $filters['q']]])
        @endif
    </div>
    @if ($featured)
        <a
            class="group flex min-h-[521px] flex-col gap-6 rounded-sm bg-gold-50 p-2 md:min-h-0 md:gap-8 md:rounded-lg md:p-4 lg:flex-row lg:items-center"
            href="{{ $featured['url'] }}"
        >
            @if ($featured['image'])
                <img
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                    width="612"
                    height="459"
                    class="h-[248px] w-full shrink-0 rounded-sm border border-neutral-100 object-cover shadow-card md:aspect-[612/459] md:h-auto md:rounded-lg lg:w-[612px]"
                    src="{{ $featured['image']['src'] }}"
                    alt="{{ $featured['image']['alt'] }}"
                >
            @endif
            <div class="flex flex-1 flex-col gap-4 md:gap-12">
                @if ($featured['category'])
                    <span class="w-fit rounded-round bg-gold-600 px-2 py-1 text-[12px] leading-4 text-paper md:text-body-md">
                        {{ $featured['category']['name'] }}
                    </span>
                @endif
                <div class="flex flex-col gap-4 md:gap-[72px]">
                    <div class="flex flex-col gap-6">
                        <h2 class="text-[18px] font-medium text-neutral-900 md:text-[32px]">{{ $featured['title'] }}</h2>
                        <p class="line-clamp-3 text-[14px] leading-normal text-neutral-800 md:line-clamp-none md:text-body-lg">
                            {{ $featured['excerpt'] }}
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <time class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md" datetime="{{ $featured['publishedAtIso'] }}">
                                @includeIsolated('public.icon', ['icon' => 'calendar-days', 'class' => 'size-4 text-gold md:size-6', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                {{ $featured['publishedAt'] }}
                            </time>
                            <span class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md">
                                <span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"></span>
                                {{ __('blog.reading_time', ['minutes' => $featured['readingTime']]) }}
                            </span>
                        </div>
                        <span class="flex items-center gap-2 text-[14px] font-medium text-neutral-900 md:text-body-lg">
                            {{ __('common.read_article') }}
                            @includeIsolated('public.icon', ['icon' => 'arrow-up-right', 'class' => 'size-4 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1 rtl:-scale-x-100 rtl:group-hover:-translate-x-1 md:size-6', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                        </span>
                    </div>
                </div>
            </div>
        </a>
    @endif
    @if (((count($posts['data']) === 0) && !$featured))
        <p class="py-16 text-center text-body-lg text-neutral-500">{{ __('common.empty_posts') }}</p>
    @else
        <div class="flex flex-col gap-16 md:gap-24">
            @if ((count($leadRow) > 0))
                <ul class="grid gap-16 sm:grid-cols-2 sm:gap-6">
                    @foreach ($leadRow as $post)
                        <li>
                            <a class="group flex min-h-[412.5px] flex-col gap-4 rounded-lg md:min-h-0" href="{{ $post['url'] }}">
                                @if ($post['image'])
                                    <img
                                        loading="lazy"
                                        decoding="async"
                                        width="612"
                                        height="400"
                                        class="h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"
                                        src="{{ $post['image']['src'] }}"
                                        alt="{{ $post['image']['alt'] }}"
                                    >
                                @endif
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <time class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md" datetime="{{ $post['publishedAtIso'] }}">
                                            @includeIsolated('public.icon', ['icon' => 'calendar-days', 'class' => 'size-4 text-gold md:size-6', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                            {{ $post['publishedAt'] }}
                                        </time>
                                        <span class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md">
                                            <span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"></span>
                                            {{ __('blog.reading_time', ['minutes' => $post['readingTime']]) }}
                                        </span>
                                    </div>
                                    <h3 class="text-[18px] font-medium text-neutral-900 md:text-[28px]">{{ $post['title'] }}</h3>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if ((count($restRows) > 0))
                <ul class="grid gap-x-6 gap-y-16 sm:grid-cols-2 md:gap-y-24 lg:grid-cols-3">
                    @foreach ($restRows as $post)
                        <li data-insight-card>
                            <a class="group flex min-h-[412.5px] flex-col gap-4 rounded-lg md:min-h-0" href="{{ $post['url'] }}">
                                @if ($post['image'])
                                    <img
                                        loading="lazy"
                                        decoding="async"
                                        width="400"
                                        height="400"
                                        class="h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"
                                        src="{{ $post['image']['src'] }}"
                                        alt="{{ $post['image']['alt'] }}"
                                    >
                                @endif
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <time class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md" datetime="{{ $post['publishedAtIso'] }}">
                                            @includeIsolated('public.icon', ['icon' => 'calendar-days', 'class' => 'size-4 text-gold md:size-6', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                            {{ $post['publishedAt'] }}
                                        </time>
                                        <span class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md">
                                            <span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"></span>
                                            {{ __('blog.reading_time', ['minutes' => $post['readingTime']]) }}
                                        </span>
                                    </div>
                                    <h3 class="text-[18px] font-medium text-neutral-900 md:text-title-lg">{{ $post['title'] }}</h3>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
    @if (count($restRows) > 2)
        <button
            type="button"
            class="mx-auto inline-flex items-center gap-2 text-body-lg font-medium text-neutral-900 transition-colors hover:text-gold"
            data-action="showMoreInsights" hidden
        >
            {{ __('common.more_insights') }}
            @includeIsolated('public.icon', ['icon' => 'chevron-down', 'class' => 'size-6 shrink-0', 'ariaHidden' => 'true'])
        </button>
    @endif
    @if (($posts['lastPage'] > 1))
        <nav class="flex items-center justify-center gap-4" aria-label="{{ __('common.pagination') }}">
            @if ($posts['prevPageUrl'])
                <a
                    class="rounded-sm border border-neutral-200 px-6 py-3 text-label-lg text-neutral-800 transition-colors hover:border-ink"
                    href="{{ $posts['prevPageUrl'] }}"
                    rel="prev"
                >
                    {{ __('common.previous') }}
                </a>
            @endif
            <span class="latin-nums text-body-md text-neutral-500">
                {{ $posts['currentPage'] }}
                /
                {{ $posts['lastPage'] }}
            </span>
            @if ($posts['nextPageUrl'])
                <a
                    class="rounded-sm border border-neutral-200 px-6 py-3 text-label-lg text-neutral-800 transition-colors hover:border-ink"
                    href="{{ $posts['nextPageUrl'] }}"
                    rel="next"
                >
                    {{ __('common.next') }}
                </a>
            @endif
        </nav>
    @endif
</div>
@if (!empty($sections['final_cta']))
    @include('public.components.cta-banner', ['spacingClass' => 'pb-[176px] pt-[176px]', 'section' => $sections['final_cta']])
@endif
