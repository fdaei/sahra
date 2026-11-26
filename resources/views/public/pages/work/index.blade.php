@php
    $basePath = route('work.index', absolute: false);
@endphp

<div class="container-sahra flex flex-col gap-12 pb-0 pt-[160px] md:pb-32 md:pt-[184px] lg:gap-[120px]">
    <div class="flex flex-col gap-16 lg:flex-row lg:items-center lg:justify-between lg:gap-10">
        <div class="flex h-[184px] max-w-[611px] flex-col gap-6 md:h-auto md:gap-12">
            <p class="eyebrow">{{ $heading['eyebrow'] }}</p>
            <div class="flex flex-col gap-6">
                <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">{{ $heading['title'] }}</h1>
                <p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">{{ $heading['description'] }}</p>
            </div>
        </div>
        @if ((count($filters) > 0))
            @includeIsolated('public.components.filter-chips', ['paramName' => 'service', 'items' => $filters, 'active' => $activeFilter, 'basePath' => $basePath, 'extraParams' => []])
        @endif
    </div>
    <div class="flex flex-col items-center gap-16 md:gap-24">
        @if ((count($projects) === 0))
            <p class="py-16 text-center text-body-lg text-neutral-500">{{ __('common.empty_projects') }}</p>
        @else
            <ul class="grid w-full gap-x-6 gap-y-16 sm:grid-cols-2 md:gap-y-24">
                @foreach ($projects as $project)
                    <li data-work-card
                        class="max-sm:h-[490px] max-sm:overflow-hidden"
                    >
                        <a class="group flex flex-col gap-4 rounded-md md:gap-10" href="{{ $project['url'] }}">
                            <div class="overflow-hidden rounded-md border border-neutral-100 shadow-card">
                                @if ($project['image'])
                                    <img loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async"
                                        width="612"
                                        height="612"
                                        class="aspect-square w-full object-cover transition-transform duration-500 ease-brand group-hover:scale-[1.06]"
                                        src="{{ $project['image']['src'] }}"
                                        alt="{{ $project['image']['alt'] }}"
                                    >
                                @else
                                    <div class="aspect-square w-full bg-neutral-100"></div>
                                @endif
                            </div>
                            <div class="flex flex-col gap-6">
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <h2 class="text-[22px] font-semibold text-neutral-900 md:text-[36px]">{{ $project['title'] }}</h2>
                                        @if ($project['industry'])
                                            <span class="flex items-center gap-2 text-[12px] font-medium text-neutral-500 md:text-label-lg">
                                                @includeIsolated('public.icon', ['icon' => 'building2', 'class' => 'size-4 shrink-0 text-gold md:size-6', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                                {{ $project['industry'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-body-md text-neutral-700 md:text-body-lg">{{ $project['excerpt'] }}</p>
                                </div>
                                @if ((count($project['services']) > 0))
                                    <ul
                                        class="flex max-h-0 flex-wrap items-center gap-2 overflow-hidden opacity-0 transition-[max-height,opacity] duration-500 ease-brand group-hover:max-h-16 group-hover:opacity-100 group-focus-visible:max-h-16 group-focus-visible:opacity-100"
                                    >
                                        @foreach ($project['services'] as $i => $service)
                                            <li class="flex items-center gap-2 text-body-md text-neutral-500">
                                                @if (($i > 0))
                                                    <span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"></span>
                                                @endif
                                                {{ $service }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
        @if (count($projects) > 4)
            <button
                type="button"
                class="inline-flex items-center gap-1 text-body-md font-medium text-neutral-900 md:gap-2 md:text-body-lg transition-colors hover:text-gold"
                data-action="loadMore" hidden
            >
                {{ __('common.more_works') }}
                @includeIsolated('public.icon', ['icon' => 'chevron-down', 'class' => 'size-4 shrink-0 md:size-6', 'ariaHidden' => 'true'])
            </button>
        @endif
    </div>
</div>
@if (!empty($sections['final_cta']))
    @include('public.components.cta-banner', ['spacingClass' => 'pb-[176px] pt-[176px]', 'section' => $sections['final_cta']])
@endif
