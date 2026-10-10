@if (! empty($faqs))
    <dl>
        @foreach ($faqs as $faq)
            <dt>{{ $faq['question'] }}</dt>
            <dd>{{ $faq['answer'] }}</dd>
        @endforeach
    </dl>
@endif
