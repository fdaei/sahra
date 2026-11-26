@php
    $contact = $settings['contact'];
    $details = array_values(array_filter([
        ['icon' => '/icons/sahra/contact/phone.svg', 'label' => __('forms.details.whatsapp'), 'value' => $contact['whatsapp'], 'href' => 'https://wa.me/'.preg_replace('/\D/', '', $contact['whatsapp'])],
        ['icon' => 'map-pin', 'label' => __('forms.details.location'), 'value' => $contact['location'], 'href' => null],
        ['icon' => 'mail', 'label' => __('forms.details.email'), 'value' => $contact['email'], 'href' => 'mailto:'.$contact['email']],
        ['icon' => '/icons/sahra/contact/users.svg', 'label' => __('forms.details.working_with'), 'value' => $contact['workingWith'], 'href' => null],
    ], fn ($row) => filled($row['value'])));
    $configuredSocialLinks = array_column($settings['socialLinks'], null, 'platform');
    $defaultSocialLinks = [
        'instagram' => ['label' => 'Instagram', 'url' => 'https://instagram.com/sahramarketing'],
        'linkedin' => ['label' => 'LinkedIn', 'url' => 'https://linkedin.com/company/sahramarketing'],
        'whatsapp' => ['label' => 'WhatsApp', 'url' => 'https://wa.me/96777811213'],
        'x' => ['label' => 'X', 'url' => 'https://x.com/sahramarketing'],
        'youtube' => ['label' => 'YouTube', 'url' => 'https://youtube.com/@sahramarketing'],
    ];
    $socialLinks = [];
    foreach ($defaultSocialLinks as $platform => $link) {
        $socialLinks[] = $configuredSocialLinks[$platform] ?? [...$link, 'icon' => $platform, 'hoverIcon' => null];
    }
    $countries = [];
    foreach (config('calling-codes') as $region => $codes) {
        foreach ($codes as $code) {
            $countries[] = [
                'key' => $region.':'.$code,
                'region' => $region,
                'label' => Locale::getDisplayRegion('-'.$region, $locale),
                'code' => $code,
            ];
        }
    }
    $collator = new Collator($locale);
    usort($countries, fn ($a, $b) => ($b['region'] === 'OM') <=> ($a['region'] === 'OM')
        ?: $collator->compare($a['label'], $b['label']));
    $selectedCountry = old('country', 'OM:+968');
    $selectedServiceIds = (array) old('service_ids', []);
    $selectedTitles = collect($services)->whereIn('id', $selectedServiceIds)->pluck('title')->implode(', ');
@endphp

<section class="section min-h-[1945px] pb-32 pt-[136px] md:min-h-0 md:pb-[204px] md:pt-[184px]">
    <div class="container-sahra max-md:px-0">
        <div class="relative overflow-visible rounded-lg bg-neutral-100 lg:min-h-[854px] lg:pe-6">
            <img
                src="/images/sahra/contact-bg-960.webp"
                srcset="/images/sahra/contact-bg-480.webp 480w, /images/sahra/contact-bg-960.webp 960w, /images/sahra/contact-bg-1487.webp 1487w"
                sizes="(min-width: 1440px) 1248px, 100vw"
                fetchpriority="high"
                alt=""
                width="1487"
                height="1058"
                class="pointer-events-none absolute inset-0 size-full rounded-lg object-cover object-center opacity-60"
                aria-hidden="true"
                decoding="async"
            >
            <div class="relative z-10 flex min-h-[854px] flex-col items-stretch gap-16 lg:flex-row lg:items-center lg:gap-9">
                <div class="flex flex-col gap-8 rounded-lg bg-white/10 p-6 backdrop-blur-[10px] md:p-12 lg:h-[854px] lg:w-[765px]">
                    <div class="flex flex-col gap-6 md:gap-12">
                        <p class="eyebrow text-[16px] before:!size-[6px] md:text-[24px] md:before:!size-[11.31px]">{{ $heading['eyebrow'] }}</p>
                        <div class="flex flex-col gap-4 md:gap-6">
                            <h1 class="text-[26px] font-semibold md:max-w-[620px] md:text-display-md">{{ $heading['title'] }}</h1>
                            <p class="max-w-[520px] text-body-lg font-normal leading-relaxed text-neutral-700 md:text-title-sm md:font-medium">
                                {{ $heading['description'] }}
                            </p>
                        </div>
                    </div>
                    <form
                        class="flex min-h-0 flex-1 flex-col gap-6"
                        action="{{ route('contact.store') }}"
                        method="post"
                    >
                        @csrf
                        <input type="hidden" name="form_started_at" value="{{ (int) (microtime(true) * 1000) }}">
                        <div class="hidden" aria-hidden="true">
                            <label for="website">Website</label>
                            <input
                                id="website"
                                type="text"
                                name="website"
                                tabindex="-1"
                                autocomplete="off"
                                value="{{ '' }}"
                            >
                        </div>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block text-label-lg text-neutral-800">{{ __('forms.contact.name') }}</label>
                                <div
                                    class="flex items-center gap-2 rounded-sm border bg-paper/80 p-3 transition-colors hover:border-neutral-200 focus-within:border-ink {{ $errors->has('name') ? '!border-[#c94a4a] !bg-[#fdf5f5]' : 'border-gold-300' }}"
                                >
                                    @includeIsolated('public.icon', ['icon' => 'user-round', 'class' => 'size-6 shrink-0 text-neutral-600', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                    <input
                                        id="name"
                                        type="text" required minlength="2" maxlength="150" autocomplete="name"
                                        class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"
                                        placeholder="{{ __('forms.contact.name_placeholder') }}"
                                        @if ($errors->has('name')) aria-invalid="true" aria-describedby="name-error" @endif
                                        name="name"
                                        value="{{ \App\Support\PublicPage::oldText('name') }}"
                                    >
                                </div>
                                @if ($errors->first('name'))
                                    <p id="name-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div>
                                <label for="brand" class="mb-2 block text-label-lg text-neutral-800">{{ __('forms.contact.brand') }}</label>
                                <div
                                    class="flex items-center gap-2 rounded-sm border bg-paper/80 p-3 transition-colors hover:border-neutral-200 focus-within:border-ink {{ $errors->has('brand_name') ? '!border-[#c94a4a] !bg-[#fdf5f5]' : 'border-gold-300' }}"
                                >
                                    @includeIsolated('public.icon', ['icon' => 'badge-check', 'class' => 'size-6 shrink-0 text-neutral-600', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                    <input
                                        id="brand"
                                        type="text" maxlength="150" autocomplete="organization"
                                        class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"
                                        placeholder="{{ __('forms.contact.brand_placeholder') }}"
                                        @if ($errors->has('brand_name')) aria-invalid="true" aria-describedby="brand-error" @endif
                                        name="brand_name"
                                        value="{{ \App\Support\PublicPage::oldText('brand_name') }}"
                                    >
                                </div>
                                @if ($errors->first('brand_name'))
                                    <p id="brand-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">
                                        {{ $errors->first('brand_name') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="relative min-w-0">
                                <label for="phone" class="mb-2 block text-label-lg text-neutral-800">{{ __('forms.contact.phone') }}</label>
                                <div
                                    dir="ltr"
                                    class="flex h-12 overflow-hidden rounded-sm border bg-paper/80 transition-colors hover:border-neutral-200 focus-within:border-ink {{ $errors->has('phone') ? '!border-[#c94a4a] !bg-[#fdf5f5]' : 'border-gold-300' }}"
                                >
                                    <select name="country" dir="ltr" class="max-w-[35%] border-0 border-e border-inherit bg-transparent py-3 ps-2 text-body-md focus:ring-0"
                                            aria-label="{{ __('forms.contact.country_search') }}">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country['key'] }}" @selected($selectedCountry === $country['key'])>
                                                {{ $country['label'] }} · {{ $country['code'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input id="phone" name="phone" type="tel" dir="ltr" autocomplete="tel" required maxlength="30"
                                           class="min-w-0 flex-1 border-0 bg-transparent px-3 py-3 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"
                                           placeholder="{{ __('forms.contact.phone_placeholder') }}"
                                           value="{{ \App\Support\PublicPage::oldText('phone') }}"
                                           @if ($errors->has('phone')) aria-invalid="true" aria-describedby="phone-error" @endif>
                                </div>
                                @if ($errors->first('phone'))
                                    <p id="phone-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">
                                        {{ $errors->first('phone') }}
                                    </p>
                                @endif
                            </div>
                            @if ((count($services) > 0))
                                <div class="relative min-w-0">
                                    <p class="mb-2 block text-label-lg text-neutral-800">{{ __('forms.contact.services') }}</p>
                                    <details class="contact-services" data-service-picker>
                                        <summary class="relative flex h-12 w-full cursor-pointer items-center rounded-sm border border-gold-300 bg-paper/80 text-start hover:border-neutral-200 focus:border-ink">
                                            @includeIsolated('public.icon', ['icon' => 'layers3', 'class' => 'pointer-events-none ms-4 size-6 shrink-0 text-neutral-600', 'strokeWidth' => 1.5])
                                            <span class="min-w-0 flex-1 truncate px-2 pe-10 text-body-md text-neutral-700"
                                                  data-selected-services="{{ __('forms.contact.services_placeholder') }}">
                                                {{ $selectedTitles ?: __('forms.contact.services_placeholder') }}
                                            </span>
                                            @includeIsolated('public.icon', ['icon' => 'chevron-down', 'class' => 'pointer-events-none absolute end-4 size-5 text-neutral-700', 'strokeWidth' => 1.5])
                                        </summary>
                                        <div class="absolute z-30 mt-2 w-full overflow-hidden rounded-sm border border-neutral-200 bg-paper/95 shadow-lg backdrop-blur">
                                            <label for="service-search" class="flex h-12 items-center gap-2 border-b border-neutral-200 px-3">
                                                @includeIsolated('public.icon', ['icon' => 'search', 'class' => 'size-5 shrink-0 text-neutral-600', 'strokeWidth' => 1.5])
                                                <span class="sr-only">{{ __('forms.contact.service_search') }}</span>
                                                <input id="service-search" type="search" data-service-search
                                                       class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md focus:ring-0"
                                                       placeholder="{{ __('forms.contact.service_search') }}">
                                            </label>
                                            <div class="max-h-[min(24rem,50vh)] overflow-y-auto overscroll-contain">
                                                @foreach ($services as $service)
                                                    <label class="flex min-h-12 cursor-pointer items-center justify-between gap-3 border-b border-neutral-200 px-3 text-body-md last:border-b-0 hover:bg-neutral-50" data-service-option>
                                                        <span>{{ $service['title'] }}</span>
                                                        <input type="checkbox" name="service_ids[]" value="{{ $service['id'] }}"
                                                               class="rounded-sm border-neutral-400 text-gold focus:ring-gold"
                                                               @checked(in_array($service['id'], $selectedServiceIds))>
                                                    </label>
                                                @endforeach
                                                <p class="px-3 py-4 text-body-md text-neutral-500" data-services-empty hidden>{{ __('forms.contact.service_empty') }}</p>
                                            </div>
                                        </div>
                                    </details>
                                    @if ($errors->has('service_ids') || $errors->has('service_ids.*'))
                                        <p role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">{{ $errors->first('service_ids') ?: $errors->first('service_ids.*') }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex min-h-0 flex-1 flex-col">
                            <label for="message" class="mb-2 block text-label-lg text-neutral-800">{{ __('forms.contact.message') }}</label>
                            <textarea
                                id="message"
                                rows="2" maxlength="5000"
                                class="h-20 min-h-0 w-full resize-none rounded-sm border bg-paper/80 p-3 text-body-md shadow-none transition-colors placeholder:text-neutral-500 hover:border-neutral-200 focus:border-ink focus:ring-0 {{ $errors->has('message') ? '!border-[#c94a4a] !bg-[#fdf5f5]' : 'border-gold-300' }}"
                                placeholder="{{ __('forms.contact.message_placeholder') }}"
                                @if ($errors->has('message')) aria-invalid="true" aria-describedby="message-error" @endif
                                name="message"
                            >{{ \App\Support\PublicPage::oldText('message') }}</textarea>
                            @if ($errors->first('message'))
                                <p id="message-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">
                                    {{ $errors->first('message') }}
                                </p>
                            @endif
                        </div>
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-1 rounded-sm bg-ink px-6 py-3 text-body-lg text-paper transition-colors hover:bg-gold hover:text-white disabled:opacity-50 md:px-8 md:py-4 md:text-title-md"
                        >
                            {{ __('forms.contact.submit') }}
                        </button>
                    </form>
                </div>
                <div class="mx-5 flex flex-col justify-between gap-14 lg:mx-0 lg:h-[724px] lg:w-[423px] lg:gap-16">
                    <div
                        class="flex flex-col gap-8 rounded-lg bg-white/10 p-6 backdrop-blur-[7.5px] lg:h-[467px] lg:justify-center lg:gap-10 lg:bg-white/30 lg:p-8"
                    >
                        <h2 class="text-title-sm font-medium text-neutral-900">{{ __('forms.details.title') }}</h2>
                        <ul class="flex flex-col gap-4 lg:gap-6">
                            @foreach ($details as $i => $row)
                                <li
                                    class="flex items-center gap-4 {{ \Illuminate\Support\Arr::toCssClasses((($i < (count($details) - 1)) ? 'border-b border-neutral-200 pb-4 lg:pb-6' : '')) }}"
                                >
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-round">
                                        @if (str_starts_with($row['icon'], '/'))
                                            <img
                                                alt=""
                                                class="h-12 w-12 object-contain"
                                                aria-hidden="true"
                                                src="{{ $row['icon'] }}"
                                            >
                                        @else
                                            @includeIsolated('public.icon', ['icon' => $row['icon'], 'class' => 'h-6 w-6 text-neutral-700', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                        @endif
                                    </span>
                                    <span class="flex min-w-0 flex-col gap-1">
                                        <span class="text-label-lg text-neutral-900">{{ $row['label'] }}</span>
                                        @if ($row['href'])
                                            <a class="truncate text-body-md text-neutral-700 hover:text-gold" href="{{ $row['href'] }}">
                                                {{ $row['value'] }}
                                            </a>
                                        @else
                                            <span class="text-body-md text-neutral-700">{{ $row['value'] }}</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if ((count($socialLinks) > 0))
                        <div class="flex flex-col gap-6 rounded-lg p-6 backdrop-blur-[3px] lg:gap-8 lg:p-7">
                            <p class="max-w-[340px] text-label-lg font-medium leading-relaxed text-neutral-800 lg:text-body-lg">
                                {{ __('forms.details.follow') }}
                            </p>
                            <ul class="flex items-center justify-between gap-3">
                                @foreach ($socialLinks as $link)
                                    <li>
                                        <a
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="group flex size-12 items-center justify-center text-neutral-700 transition-colors hover:text-gold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ink lg:size-12"
                                            href="{{ $link['url'] }}"
                                            aria-label="{{ $link['label'] }}"
                                        >
                                            @includeIsolated('public.components.social-icon', ['class' => 'size-14', 'icon' => $link['icon'], 'hoverIcon' => $link['hoverIcon']])
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@if (session('success'))
    <div class="container-sahra" data-modal-panel data-show-modal aria-labelledby="contact-success-title">
        <div
            class="relative flex max-h-[calc(100vh-40px)] w-full max-w-[706px] flex-col items-center overflow-y-auto rounded-lg bg-white p-6 outline-none md:p-12"
            role="status"
        >
            <button
                type="button"
                class="absolute end-4 top-4 rounded-full p-2 text-neutral-700 transition-colors hover:bg-neutral-100"
                aria-label="{{ __('forms.newsletter.close') }}"
                data-close-modal hidden
            >
                @includeIsolated('public.icon', ['icon' => 'x', 'class' => 'size-5', 'ariaHidden' => 'true'])
            </button>
            <img
                src="/images/sahra/checklist-success.svg"
                alt=""
                width="96"
                height="94"
                class="mb-12 size-24 object-contain"
                aria-hidden="true"
            >
            <h2 id="contact-success-title" class="max-w-[520px] text-center text-[24px] font-medium leading-normal text-neutral-900">
                {{ session('success') }}
            </h2>
            <a
                class="mt-8 inline-flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-white"
                href="{{ ('/' . app()->getLocale() . '/contact') }}"
            >
                {{ __('forms.newsletter.consultation') }}
                @includeIsolated('public.icon', ['icon' => 'arrow-up-right', 'class' => 'size-6 rtl:-scale-x-100', 'ariaHidden' => 'true'])
            </a>
        </div>
    </div>
@endif
