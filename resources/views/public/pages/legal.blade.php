@php
    $isPrivacy = request()->routeIs('legal.privacy');
    $lastUpdated = $updatedAt ? __('common.last_updated', ['date' => \Carbon\Carbon::parse($updatedAt)->translatedFormat('F Y')]) : null;
@endphp

<section
    class="min-h-[2499px] pb-[160px] pt-[160px] md:min-h-0 md:pt-[192px] {{ \Illuminate\Support\Arr::toCssClasses(($isPrivacy ? 'md:pb-[250px]' : 'md:pb-[202px]')) }}"
>
    <div class="container-sahra">
        <div class="flex flex-col gap-4 md:gap-6 lg:flex-row lg:items-start lg:justify-between lg:gap-16">
            <div class="flex max-w-[612px] flex-col gap-4 md:gap-12">
                <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($lastUpdated)
                <p class="shrink-0 text-[12px] leading-normal text-neutral-700 md:text-title-sm">{{ $lastUpdated }}</p>
            @endif
        </div>
        <article
            class="prose prose-neutral mt-10 max-w-none md:mt-24 prose-headings:mb-4 prose-headings:mt-8 prose-headings:text-[22px] md:prose-headings:mb-6 md:prose-headings:mt-16 md:prose-headings:text-heading-lg prose-headings:font-medium prose-headings:text-neutral-900 first:prose-headings:mt-0 prose-p:my-0 prose-p:text-body-md prose-p:text-neutral-800 md:prose-p:text-body-xl prose-a:text-gold prose-a:no-underline hover:prose-a:underline prose-ul:my-0 prose-ul:list-none prose-ul:ps-0 prose-li:my-0 prose-li:ps-0 prose-li:text-body-md prose-li:text-neutral-800 md:prose-li:text-body-xl prose-li:marker:content-none [&_p+p]:mt-4 md:[&_p+p]:mt-6 [&_p+ul]:mt-0 [&_ul+p]:mt-4 md:[&_ul+p]:mt-6"
        >{!! $content !!}</article>
    </div>
</section>
