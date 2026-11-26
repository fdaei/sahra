@php
    $title = $seo['title'];
    $message = $seo['description'];
    $homeUrl = route('home', ['locale' => $locale], absolute: false);
@endphp

<section class="section section-first h-[874px] overflow-hidden md:h-[1024px]">
    <div class="container-sahra flex flex-col items-center text-center">
        @if (($status === 404))
            <img
                src="/images/sahra/404-horizon-480.webp"
                srcset="/images/sahra/404-horizon-480.webp 480w, /images/sahra/404-horizon-1120.webp 1120w"
                sizes="(min-width: 1120px) 1120px, 100vw"
                alt=""
                width="560"
                height="560"
                class="w-full max-w-[560px]"
                aria-hidden="true"
            >
        @else
            <p
                class="latin-nums bg-gradient-to-br from-gold-400 to-gold bg-clip-text font-semibold leading-none text-transparent [font-size:clamp(5rem,20vw,10rem)]"
                aria-hidden="true"
            >
                {{ $status }}
            </p>
        @endif
        <div class="flex max-w-[506px] flex-col items-center gap-8 md:-mt-16">
            <div class="flex flex-col items-center gap-4">
                <h1 class="text-heading-xl font-medium">{{ $title }}</h1>
                <p class="text-title-sm font-medium text-neutral-700">{{ $message }}</p>
            </div>
            <a
                class="inline-flex items-center gap-1 rounded-sm bg-ink px-8 py-4 text-title-lg text-paper transition-colors hover:bg-gold hover:text-white"
                href="{{ $homeUrl }}"
            >
                {{ __('errors.back_home') }}
                @includeIsolated('public.icon', ['icon' => 'arrow-right', 'class' => 'size-6 shrink-0 rtl:-scale-x-100', 'ariaHidden' => 'true'])
            </a>
        </div>
    </div>
</section>
