{{-- Fallback for Pages/Contact.vue. --}}
@php($contact = $props['settings']['contact'] ?? [])
<section>
    @include('seo.partials.heading', ['heading' => $props['heading'] ?? []])
    @if (array_filter($contact))
        <address>
            @if (filled($contact['email'] ?? null))<p><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></p>@endif
            @if (filled($contact['phone'] ?? null))<p><a href="tel:{{ preg_replace('/[^\d+]/', '', $contact['phone']) }}">{{ $contact['phone'] }}</a></p>@endif
            @if (filled($contact['whatsapp'] ?? null))<p>WhatsApp: {{ $contact['whatsapp'] }}</p>@endif
            @if (filled($contact['location'] ?? null))<p>{{ $contact['location'] }}</p>@endif
            @if (filled($contact['workingWith'] ?? null))<p>{{ $contact['workingWith'] }}</p>@endif
        </address>
    @endif
</section>

@foreach ($props['sections'] ?? [] as $section)
    <x-seo.section :section="$section" />
@endforeach
