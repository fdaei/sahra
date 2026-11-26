@php
    $meta = array_filter([
        ['icon' => 'calendar-days', 'label' => __('blog.date'), 'value' => $post['publishedAt']],
        ['icon' => 'pen-line', 'label' => __('blog.written_by'), 'value' => $post['author']['name'] ?? null],
        ['icon' => 'tag', 'label' => __('blog.subject'), 'value' => $post['category']['name'] ?? null],
    ], fn ($row) => filled($row['value']));
    $articleParts = \App\Support\PublicPage::articleParts($post['content'], $leadMagnet !== null);
    $shareUrl = rawurlencode($seo['canonical'] ?? '');
    $xShare = 'https://x.com/intent/tweet?url='.$shareUrl.'&text='.rawurlencode($post['title']);
    $linkedInShare = 'https://www.linkedin.com/sharing/share-offsite/?url='.$shareUrl;
@endphp

<article class="container-sahra flex flex-col gap-0 pb-0 pt-[160px] md:gap-24 md:pb-32 md:pt-[184px]">
    <div class="flex flex-col gap-11 md:gap-16">
        <div class="flex flex-col gap-[38px] lg:flex-row lg:items-start lg:justify-between lg:gap-10">
            <div class="flex min-h-[181px] max-w-[612px] flex-col gap-6 px-3 md:min-h-0 md:px-0">
                <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-[40px]">{{ $post['title'] }}</h1>
                @if ($post['subtitle'])
                    <p class="text-[16px] font-normal leading-normal text-neutral-700 md:text-[18px] md:font-medium">{{ $post['subtitle'] }}</p>
                @endif
            </div>
            @if ((count($meta) > 0))
                <dl
                    class="grid min-h-[106px] w-full max-w-[346px] shrink-0 grid-cols-2 grid-rows-2 gap-x-[92px] gap-y-[26px] md:flex md:min-h-0 md:w-auto md:flex-col md:gap-6"
                >
                    @foreach ($meta as $row)
                        <div class="flex flex-col gap-1">
                            <dt class="flex items-center gap-2">
                                @includeIsolated('public.icon', ['icon' => $row['icon'], 'class' => 'size-5 shrink-0 text-gold', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                <span class="text-label-lg text-neutral-1000">{{ $row['label'] }}</span>
                            </dt>
                            <dd class="text-body-md text-neutral-800">{{ $row['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            @endif
        </div>
        @if ($post['image'])
            <img fetchpriority="high" decoding="async"
                width="1248"
                height="624"
                class="h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card md:h-auto md:aspect-[1248/624]"
                src="{{ $post['image']['src'] }}"
                alt="{{ $post['image']['alt'] }}"
            >
        @endif
    </div>
    <div class="mt-[35px] flex min-h-[85px] flex-col gap-4 max-md:sticky max-md:top-24 max-md:z-20 max-md:bg-paper max-md:pb-3 md:hidden">
        <p class="text-[14px] font-medium leading-[21px] text-neutral-900">{{ __('blog.share') }}</p>
        <div class="flex gap-4">
            <button
                type="button"
                class="share-button size-12"
                aria-label="{{ __('blog.copy_link') }}"
                data-action="copyLink" hidden data-copied-label="{{ __('blog.link_copied') }}"
            >
                @includeIsolated('public.icon', ['icon' => 'link2', 'class' => 'size-5', 'ariaHidden' => 'true'])
            </button>
            <a
                target="_blank"
                rel="noopener noreferrer"
                class="share-button size-12"
                aria-label="X"
                href="{{ $xShare }}"
            >
                <span class="text-[18px] font-medium">X</span>
            </a>
            <a
                target="_blank"
                rel="noopener noreferrer"
                class="share-button size-12"
                aria-label="LinkedIn"
                href="{{ $linkedInShare }}"
            >
                @includeIsolated('public.icon', ['icon' => 'linkedin', 'class' => 'size-5', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
            </a>
        </div>
    </div>
    <div class="mt-6 flex justify-center gap-10 md:mt-0">
        <div class="hidden w-[119px] shrink-0 lg:block" aria-hidden="true"></div>
        <div class="flex w-full max-w-[826px] flex-col gap-10 md:gap-18">
            @foreach ($articleParts as $part)
                @if ($part !== null)
                    <div
                        class="prose prose-neutral max-w-none max-md:[&_h3]:mb-6 max-md:[&_h3]:mt-10 max-md:[&_h3]:text-[20px] max-md:[&_h3]:font-medium max-md:[&_h3]:leading-[30px] max-md:[&_h3:first-child]:mt-0 max-md:[&_h3:first-child]:leading-[33px] max-md:[&_p]:m-0 max-md:[&_p]:text-[14px] max-md:[&_p]:leading-[21px] prose-headings:font-medium prose-a:text-gold prose-a:no-underline hover:prose-a:underline"
                    >{!! $part !!}</div>
                @elseif ($leadMagnet)
                    @include('public.components.sections.lead-magnet', ['inline' => true, 'section' => $leadMagnet])
                @endif
            @endforeach
            @if (count($post['schemaBlocks']['steps']))
                <section class="prose prose-neutral max-w-none">
                    <h2>{{ $post['schemaBlocks']['howtoTitle'] }}</h2>
                    <ol>
                        @foreach ($post['schemaBlocks']['steps'] as $index => $step)
                            <li>
                                <h3>{{ $step['name'] }}</h3>
                                <p class="whitespace-pre-line">{{ $step['text'] }}</p>
                            </li>
                        @endforeach
                    </ol>
                </section>
            @endif
            @if (count($post['schemaBlocks']['faqs']))
                <section class="prose prose-neutral max-w-none">
                    <h2>{{ __('blog.schema_faq_heading') }}</h2>
                    @foreach ($post['schemaBlocks']['faqs'] as $index => $faq)
                        <div>
                            <h3>{{ $faq['question'] }}</h3>
                            <p class="whitespace-pre-line">{{ $faq['answer'] }}</p>
                        </div>
                    @endforeach
                </section>
            @endif
            @if ((count($post['tags']) > 0))
                <div class="border-t border-neutral-100 pt-8">
                    <p class="mb-3 text-label-md text-neutral-500">{{ __('blog.tags') }}</p>
                    <ul class="flex flex-wrap gap-2">
                        @foreach ($post['tags'] as $tag)
                            <li class="rounded-round border border-neutral-200 px-4 py-2 text-label-md text-neutral-700">{{ $tag['name'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="hidden w-[119px] shrink-0 flex-col items-center gap-6 lg:sticky lg:top-32 lg:flex lg:self-start">
            <p class="text-center text-label-lg text-neutral-900">{{ __('blog.share') }}</p>
            <div class="flex flex-col gap-4">
                <button
                    type="button"
                    class="share-button size-[68px]"
                    aria-label="{{ __('blog.copy_link') }}"
                    data-action="copyLink" hidden data-copied-label="{{ __('blog.link_copied') }}"
                >
                    @includeIsolated('public.icon', ['icon' => 'link2', 'class' => 'size-6', 'ariaHidden' => 'true'])
                </button>
                <a
                    target="_blank"
                    rel="noopener noreferrer"
                    class="share-button size-[68px]"
                    aria-label="X"
                    href="{{ $xShare }}"
                >
                    <svg
                        class="size-5"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
                         />
                    </svg>
                </a>
                <a
                    target="_blank"
                    rel="noopener noreferrer"
                    class="share-button size-[68px]"
                    aria-label="LinkedIn"
                    href="{{ $linkedInShare }}"
                >
                    @includeIsolated('public.icon', ['icon' => 'linkedin', 'class' => 'size-6', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                </a>
            </div>
        </div>
    </div>
    <section class="mx-auto mt-16 w-full max-w-[826px] border-t border-neutral-200 pt-10" aria-labelledby="comments-heading">
        <h2 id="comments-heading" class="text-[26px] font-semibold text-neutral-900">{{ __('blog.comments') }}</h2>
        @if ((count($comments) === 0))
            <p class="mt-5 text-neutral-700">{{ __('blog.comment_empty') }}</p>
        @else
            <ul class="mt-6 divide-y divide-neutral-200">
                @foreach ($comments as $comment)
                    <li class="py-5">
                        <div class="flex flex-wrap items-baseline gap-3">
                            <strong>{{ $comment['name'] }}</strong>
                            <time class="text-sm text-neutral-600" datetime="{{ $comment['date'] }}">{{ $comment['date'] }}</time>
                        </div>
                        <p class="mt-2 whitespace-pre-wrap text-neutral-800">{{ $comment['body'] }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
        <form class="mt-10 flex flex-col gap-4" action="{{ $commentUrl }}" method="post">
            @csrf
            <input type="hidden" name="_form" value="comment">
            <h3 class="text-xl font-semibold">{{ __('blog.leave_comment') }}</h3>
            @if ($commentSuccess)
                <p role="status" class="text-neutral-800">{{ __('blog.comment_pending') }}</p>
            @endif
            <label class="flex flex-col gap-2">
                {{ __('blog.comment_name') }}
                <input
                    required
                    maxlength="100"
                    class="rounded-lg border-neutral-300"
                    name="name"
                    value="{{ old('_form') === 'comment' ? \App\Support\PublicPage::oldText('name') : '' }}"
                >
                @if (old('_form') === 'comment' && $errors->has('name'))
                    <span role="alert" class="text-red-700">{{ $errors->first('name') }}</span>
                @endif
            </label>
            <label class="flex flex-col gap-2">
                {{ __('blog.comment_email') }}
                <input
                    type="email"
                    required
                    maxlength="255"
                    class="rounded-lg border-neutral-300"
                    name="email"
                    value="{{ old('_form') === 'comment' ? \App\Support\PublicPage::oldText('email') : '' }}"
                >
                @if (old('_form') === 'comment' && $errors->has('email'))
                    <span role="alert" class="text-red-700">{{ $errors->first('email') }}</span>
                @endif
            </label>
            <label class="flex flex-col gap-2">
                {{ __('blog.comment_body') }}
                <textarea
                    required
                    maxlength="5000"
                    rows="5"
                    class="rounded-lg border-neutral-300"
                    name="body"
                >{{ old('_form') === 'comment' ? \App\Support\PublicPage::oldText('body') : '' }}</textarea>
                @if (old('_form') === 'comment' && $errors->has('body'))
                    <span role="alert" class="text-red-700">{{ $errors->first('body') }}</span>
                @endif
            </label>
            <button type="submit" class="self-start rounded-lg bg-neutral-900 px-6 py-3 text-white disabled:opacity-50">
                {{ __('blog.comment_submit') }}
            </button>
        </form>
    </section>
    @if ((count($post['related']) > 0))
        <section class="mt-16 flex flex-col gap-10 md:mt-0 md:gap-12">
            <h2 class="text-[22px] font-semibold leading-normal text-neutral-900 md:text-[40px]">{{ __('blog.related') }}</h2>
            <ul class="flex gap-4 overflow-x-auto md:grid md:gap-6 md:overflow-visible sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($post['related'] as $related)
                    <li class="w-[268px] shrink-0 md:w-auto">
                        <a class="group flex flex-col gap-4 rounded-lg" href="{{ $related['url'] }}">
                            @if ($related['image'])
                                <img loading="lazy" decoding="async"
                                    width="400"
                                    height="400"
                                    class="size-[268px] rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px] md:w-full"
                                    src="{{ $related['image']['src'] }}"
                                    alt="{{ $related['image']['alt'] }}"
                                >
                            @endif
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-4">
                                    <time class="flex items-center gap-2 text-body-md text-neutral-500" datetime="{{ $related['publishedAtIso'] }}">
                                        @includeIsolated('public.icon', ['icon' => 'calendar-days', 'class' => 'size-6 text-gold', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                        {{ $related['publishedAt'] }}
                                    </time>
                                    <span class="flex items-center gap-2 text-body-md text-neutral-500">
                                        <span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"></span>
                                        {{ __('blog.reading_time', ['minutes' => $related['readingTime']]) }}
                                    </span>
                                </div>
                                <h3 class="text-title-lg text-neutral-900">{{ $related['title'] }}</h3>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
</article>
@if ($finalCta)
    @include('public.components.cta-banner', ['spacingClass' => 'pb-[176px] pt-[176px]', 'section' => $finalCta])
@endif
