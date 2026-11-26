@if (!empty($schemaBlocks['steps']) || !empty($schemaBlocks['faqs']))
    <div class="container-sahra py-12 md:py-20">
        @if (!empty($schemaBlocks['steps']))
            <section class="prose prose-neutral max-w-none">
                <h2>{{ $schemaBlocks['howtoTitle'] }}</h2>
                <ol>
                    @foreach ($schemaBlocks['steps'] as $step)
                        <li>
                            <h3>{{ $step['name'] }}</h3>
                            <p class="whitespace-pre-line">{{ $step['text'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </section>
        @endif
        @if (!empty($schemaBlocks['faqs']))
            <section class="prose prose-neutral max-w-none">
                <h2>{{ __('blog.schema_faq_heading') }}</h2>
                @foreach ($schemaBlocks['faqs'] as $faq)
                    <div>
                        <h3>{{ $faq['question'] }}</h3>
                        <p class="whitespace-pre-line">{{ $faq['answer'] }}</p>
                    </div>
                @endforeach
            </section>
        @endif
    </div>
@endif
