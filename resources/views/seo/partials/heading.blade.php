{{-- The eyebrow / title / description block that opens listing pages. --}}
@if (filled($heading['eyebrow'] ?? null))
    <p>{{ $heading['eyebrow'] }}</p>
@endif
<h1>{{ $heading['title'] ?? '' }}</h1>
@if (filled($heading['description'] ?? null))
    <p>{{ $heading['description'] }}</p>
@endif
