<section class="relative overflow-hidden pt-[160px] md:pt-[184px]">
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="relative mx-auto h-full w-full max-w-frame">
            <img
                alt=""
                width="1597"
                height="1814"
                class="absolute -top-[93px] start-[667px] w-[1597px] max-w-none"
                src="{{ Vite::asset('resources/images/decor/arc-rings-service-r.svg') }}"
            >
        </div>
    </div>
    <div class="container-sahra relative flex flex-col gap-[72px] lg:gap-[200px]">
        <div class="flex h-[184px] max-w-[612px] flex-col gap-6 md:h-auto md:gap-12">
            <p class="eyebrow">{{ $heading['eyebrow'] }}</p>
            <div class="flex flex-col gap-6">
                <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">{{ $heading['title'] }}</h1>
                <p class="text-[16px] leading-normal text-neutral-700 md:text-title-sm md:font-medium">{{ $heading['description'] }}</p>
            </div>
        </div>
        <div class="relative flex flex-col gap-24 lg:gap-[224px]">
            <div class="pointer-events-none absolute inset-x-0 top-1/2 -z-10 hidden -translate-y-1/2 lg:block" aria-hidden="true">
                <img
                    alt=""
                    width="1924"
                    height="2186"
                    loading="lazy"
                    class="absolute -top-[1093px] -start-[647px] w-[1924px] max-w-none"
                    src="{{ Vite::asset('resources/images/decor/arc-rings-service-l.svg') }}"
                >
            </div>
            @foreach ($services as $i => $service)
                <article id="{{ $service['slug'] }}"
                    class="flex flex-col gap-10 lg:h-auto lg:flex-row lg:items-start lg:justify-between lg:gap-[137px] {{ \Illuminate\Support\Arr::toCssClasses([((($i % 2) === 1) ? 'lg:flex-row-reverse' : ''), (($i < 2) ? 'max-lg:h-[628px]' : 'max-lg:h-[612px]')]) }}"
                >
                    <div class="order-2 flex flex-col gap-6 lg:order-none lg:max-w-[507px] lg:gap-10 lg:py-12">
                        <h2 class="text-[24px] font-semibold leading-normal text-neutral-900 md:text-display-md">{{ $service['title'] }}</h2>
                        <div class="flex flex-col gap-6 lg:gap-12">
                            <p class="text-[16px] leading-normal text-neutral-800 md:text-title-md">{{ $service['description'] }}</p>
                            @if ((count($service['features']) > 0))
                                <ul class="flex flex-col gap-4">
                                    @foreach ($service['features'] as $fi => $feature)
                                        <li class="ms-6 list-disc text-[16px] font-medium leading-normal text-neutral-800 md:ms-[27px] md:text-title-sm">
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    @if ($service['image'])
                        <img loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async"
                            width="{{ $service['image']['width'] }}" height="{{ $service['image']['height'] }}"
                            class="order-1 h-[272px] w-full rounded-sm object-contain lg:order-none lg:h-auto lg:aspect-[604/786] lg:w-[604px] lg:shrink-0"
                            src="{{ $service['image']['src'] }}"
                            alt="{{ $service['image']['alt'] }}"
                        >
                    @else
                        <div class="order-1 h-[272px] w-full rounded-sm bg-neutral-100 lg:order-none lg:h-auto lg:aspect-[604/786] lg:w-[604px] lg:shrink-0"></div>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
@if (!empty($sections['final_cta']))
    @include('public.components.cta-banner', ['spacingClass' => 'pb-[176px] pt-[176px]', 'section' => $sections['final_cta']])
@endif
