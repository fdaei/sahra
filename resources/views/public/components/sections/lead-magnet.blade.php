@php
    $inline ??= false;
    $mobileOffcanvas ??= false;
    $class ??= '';
    $submitUrl = $section['submitUrl'] ?? route('newsletter.store', absolute: false);
    $wasSubmitted = old('_form') === 'lead-magnet';
    $deliveryResult = session('lead_magnet', []);
    $isComplete = !empty($deliveryResult) || ($template === 'public.pages.home' && session('success'));
@endphp

<section
    class="{{ $class }} {{ \Illuminate\Support\Arr::toCssClasses([($inline ? '' : 'py-14 md:py-18 lg:py-24'), ($mobileOffcanvas ? 'max-md:pb-0' : '')]) }}"
>
    @if ($mobileOffcanvas)
        <div class="container-sahra md:hidden">
            <div class="relative flex w-full items-end justify-between gap-4 overflow-hidden rounded-sm bg-black px-4 py-6 text-white">
                <img
                    src="/images/sahra/lead-magnet-large-480.webp"
                    srcset="/images/sahra/lead-magnet-large-480.webp 480w, /images/sahra/lead-magnet-large-1024.webp 1024w"
                    sizes="calc(100vw - 40px)" loading="lazy" decoding="async" fetchpriority="low"
                    alt=""
                    class="pointer-events-none absolute inset-0 size-full object-cover"
                    aria-hidden="true"
                >
                <div
                    class="pointer-events-none absolute inset-0 bg-[linear-gradient(90deg,rgba(0,0,0,0)_0%,rgba(0,0,0,1)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))] rtl:bg-[linear-gradient(270deg,rgba(0,0,0,0)_0%,rgba(0,0,0,1)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))]"
                    aria-hidden="true"
                ></div>
                <div class="relative z-10 flex flex-col items-start gap-3">
                    <p class="text-[18px] font-normal leading-normal text-white" style="color: {{ (($section['colors']['title'] ?? null) ?: null) }};">
                        {{ $section['title'] }}
                    </p>
                    <p
                        class="text-[12px] font-medium leading-normal text-neutral-200"
                        style="color: {{ (($section['colors']['description'] ?? null) ?: null) }};"
                    >
                        {{ $section['description'] }}
                    </p>
                </div>
                @if ($section['primaryCta'])
                    <a
                        class="group relative z-10 shrink-0 rounded-sm border border-white px-3 py-3 text-[14px] font-normal leading-normal text-white transition-colors duration-300 hover:border-gold hover:bg-gold hover:text-white"
                        href="#checklist-signup" data-open-modal
                    >
                        {{ $section['primaryCta']['label'] }}
                        @includeIsolated('public.components.button-icon', ['name' => $section['primaryCta']['icon'], 'hoverName' => $section['primaryCta']['hoverIcon']])
                    </a>
                @endif
            </div>
        </div>
    @endif
    <div class="{{ \Illuminate\Support\Arr::toCssClasses([($inline ? '' : 'container-sahra'), ($mobileOffcanvas ? 'max-md:hidden' : '')]) }}">
        <div
            class="relative mx-auto w-full max-w-[1101px] overflow-hidden bg-black text-white {{ \Illuminate\Support\Arr::toCssClasses(($inline ? 'min-h-[123px] rounded-sm p-8 rtl:min-h-[128px]' : 'min-h-[193px] rounded-sm px-8 py-10 sm:px-12 lg:p-16 rtl:min-h-[200px]')) }}"
        >
            <img
                height="1024"
                class="pointer-events-none absolute max-w-none {{ \Illuminate\Support\Arr::toCssClasses((($section['image']['src'] ?? null) ? 'inset-0 size-full object-cover' : ($inline ? 'left-[-22.52%] top-[-290.02%] h-[606.35%] w-[137.77%]' : 'inset-inline-0 bottom-[-90px] h-auto w-[102.73%] object-cover rtl:-scale-x-100 max-lg:inset-0 max-lg:size-full max-lg:object-cover max-lg:object-bottom'))) }}"
                decoding="async" loading="lazy" fetchpriority="low"
                src="{{ $section['image']['src'] ?? ($inline ? '/images/sahra/lead-magnet-small-600.webp' : '/images/sahra/lead-magnet-large-480.webp') }}"
                @empty($section['image'])
                    @if ($inline)
                        srcset="/images/sahra/lead-magnet-small-600.webp 600w, /images/sahra/lead-magnet-small-1200.webp 1200w"
                        sizes="(min-width: 1024px) 826px, calc(100vw - 40px)"
                    @else
                        srcset="/images/sahra/lead-magnet-large-480.webp 480w, /images/sahra/lead-magnet-large-1024.webp 1024w"
                        sizes="(min-width: 1200px) 1101px, calc(100vw - 40px)"
                    @endif
                @endempty
                alt="{{ (($section['image']['alt'] ?? null) ?: '') }}"
                width="{{ ($inline ? 1536 : 1024) }}"
                aria-hidden="{{ (($section['image']['alt'] ?? null) ? null : 'true') }}"
            >
            <div
                class="pointer-events-none absolute inset-0 {{ \Illuminate\Support\Arr::toCssClasses(($inline ? 'bg-black/30' : 'bg-[linear-gradient(90deg,rgba(0,0,0,1)_0%,rgba(0,0,0,0)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))] rtl:bg-[linear-gradient(270deg,rgba(0,0,0,1)_0%,rgba(0,0,0,0)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))]')) }}"
                aria-hidden="true"
            ></div>
            <div
                class="relative z-10 flex flex-col items-start justify-between gap-8 md:flex-row md:items-end {{ \Illuminate\Support\Arr::toCssClasses(($inline ? 'min-h-[59px]' : 'min-h-[65px] rtl:min-h-[72px]')) }}"
            >
                <div class="flex flex-col items-start gap-2">
                    <h2
                        class="font-medium leading-normal text-white {{ \Illuminate\Support\Arr::toCssClasses(($inline ? 'text-[20px]' : 'text-[20px] md:text-[22px]')) }}"
                        style="color: {{ (($section['colors']['title'] ?? null) ?: null) }};"
                    >
                        {{ $section['title'] }}
                    </h2>
                    <p
                        class="font-normal leading-normal text-neutral-100 {{ \Illuminate\Support\Arr::toCssClasses(($inline ? 'text-[14px]' : 'text-[16px]')) }}"
                        style="color: {{ (($section['colors']['description'] ?? null) ?: null) }};"
                    >
                        {{ $section['description'] }}
                    </p>
                </div>
                @if ($section['primaryCta'])
                    <a
                        class="group inline-flex shrink-0 items-center justify-center rounded-sm border border-white font-normal leading-normal text-white transition-colors duration-300 hover:border-gold hover:text-gold {{ \Illuminate\Support\Arr::toCssClasses(($inline ? 'px-6 py-3 text-[18px]' : 'px-8 py-4 text-[20px]')) }}"
                        href="#checklist-signup" data-open-modal
                    >
                        {{ $section['primaryCta']['label'] }}
                        @includeIsolated('public.components.button-icon', ['name' => $section['primaryCta']['icon'], 'hoverName' => $section['primaryCta']['hoverIcon']])
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div id="checklist-signup" class="mx-auto flex justify-center pt-5" data-modal-panel
         aria-labelledby="{{ $isComplete ? 'checklist-success-title' : 'checklist-title' }}"
         @if ($isComplete || $wasSubmitted) data-show-modal @endif>
            <div
                class="relative flex max-h-[calc(100vh-40px)] w-full max-w-[706px] flex-col items-center overflow-y-auto rounded-lg bg-white p-6 outline-none md:p-12"
            >
                <button
                    type="button"
                    class="absolute end-4 top-4 rounded-full p-2 text-neutral-700 transition-colors hover:bg-neutral-100"
                    aria-label="{{ __('forms.newsletter.close') }}"
                    data-close-modal hidden
                >
                    @includeIsolated('public.icon', ['icon' => 'x', 'class' => 'size-5', 'ariaHidden' => 'true'])
                </button>
                @if ($isComplete)
                    <img
                        src="/images/sahra/checklist-success.svg"
                        alt=""
                        width="96"
                        height="94"
                        class="mb-12 size-24 object-contain"
                        aria-hidden="true"
                    >
                    <h2 id="checklist-success-title" class="max-w-[520px] text-center text-[24px] font-medium leading-normal text-neutral-900">
                        @if (($deliveryResult['downloaded'] ?? false))
                            {{ __('forms.newsletter.downloaded') }}
                        @endif
                        @if ((($deliveryResult['downloaded'] ?? false) && (($deliveryResult['emailed'] ?? false) || ($deliveryResult['email_failed'] ?? false))))
                            <br>
                        @endif
                        @if (($deliveryResult['emailed'] ?? false))
                            {{ __('forms.newsletter.emailed') }}
                        @elseif (($deliveryResult['email_failed'] ?? false))
                            {{ __('forms.newsletter.email_failed') }}
                        @elseif ((!($deliveryResult['downloaded'] ?? false) && !($section['delivery']['email'] ?? null)))
                            {{ session('success') ?? __('forms.newsletter.sent') }}
                        @endif
                    </h2>
                    @if (!empty($deliveryResult['downloaded']) && !empty($section['downloadUrl']))
                        <a class="mt-4 text-gold underline" href="{{ $section['downloadUrl'] }}" download data-download-ready>
                            {{ __('forms.newsletter.download_file') }}
                        </a>
                    @endif
                    <a
                        class="mt-8 inline-flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-white"
                        href="{{ ('/' . app()->getLocale() . '/contact') }}"
                    >
                        {{ __('forms.newsletter.consultation') }}
                        @includeIsolated('public.icon', ['icon' => 'arrow-up-right', 'class' => 'size-6 rtl:-scale-x-100', 'ariaHidden' => 'true'])
                    </a>
                @else
                    <div class="flex w-full flex-col items-center gap-6 text-center">
                        <h2 id="checklist-title" class="text-[26px] font-medium leading-normal text-neutral-900 md:text-[32px]">
                            {{ __('forms.newsletter.title') }}
                        </h2>
                        <p class="max-w-[612px] text-[14px] leading-normal text-neutral-700">{{ __('forms.newsletter.description') }}</p>
                    </div>
                    <form
                        class="mt-4 flex w-full max-w-[396px] flex-col gap-6 md:mt-8"
                        action="{{ $submitUrl }}"
                        method="post"
                    >
                        @csrf
                        <input type="hidden" name="_form" value="lead-magnet">
                        <input type="hidden" name="source" value="{{ $inline ? 'article' : 'home' }}">
                        <div class="hidden" aria-hidden="true">
                            <label for="checklist-website">Website</label>
                            <input
                                id="checklist-website"
                                tabindex="-1"
                                autocomplete="off"
                                name="website"
                                value="{{ '' }}"
                            >
                        </div>
                        <div>
                            <label for="checklist-name" class="mb-2 block text-[14px] font-medium text-neutral-800">{{ __('forms.newsletter.name') }}</label>
                            <div class="flex items-center gap-2 rounded-sm border border-gold-300 bg-white/80 p-3 focus-within:border-ink">
                                @includeIsolated('public.icon', ['icon' => 'user-round', 'class' => 'size-6 shrink-0 text-neutral-600', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                <input
                                    id="checklist-name"
                                    type="text"
                                    autocomplete="name"
                                    required
                                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-[14px] focus:ring-0"
                                    placeholder="{{ __('forms.newsletter.name_placeholder') }}"
                                    name="name"
                                    value="{{ $wasSubmitted ? \App\Support\PublicPage::oldText('name') : '' }}"
                                >
                            </div>
                            @if ($wasSubmitted && $errors->has('name'))
                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="checklist-email" class="mb-2 block text-[14px] font-medium text-neutral-800">
                                {{ __('forms.newsletter.email') }}
                            </label>
                            <div class="flex items-center gap-2 rounded-sm border border-gold-300 bg-white/80 p-3 focus-within:border-ink">
                                @includeIsolated('public.icon', ['icon' => 'mail', 'class' => 'size-6 shrink-0 text-neutral-600', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                <input
                                    id="checklist-email"
                                    type="email"
                                    autocomplete="email"
                                    required
                                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-[14px] focus:ring-0"
                                    placeholder="{{ __('forms.newsletter.email_placeholder') }}"
                                    name="email"
                                    value="{{ $wasSubmitted ? \App\Support\PublicPage::oldText('email') : '' }}"
                                >
                            </div>
                            @if ($wasSubmitted && $errors->has('email'))
                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <button
                            type="submit"
                            class="mx-auto rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-white disabled:opacity-60"
                        >
                            {{ __('forms.newsletter.submit') }}
                        </button>
                    </form>
                    <p class="mt-8 text-center text-[12px] font-medium text-neutral-700">{{ __('forms.newsletter.privacy') }}</p>
                @endif
            </div>
        </div>
</section>
