<form action="{{ route('contact.store') }}" method="post" class="my-12 grid max-w-xl gap-6">
    @csrf
    @if ($errors->any())
        <ul role="alert">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    @endif
    @foreach (['name' => 'name', 'brand_name' => 'brand', 'phone' => 'phone'] as $field => $label)
        <label>{{ __('forms.contact.'.$label) }}<input class="block w-full" name="{{ $field }}" value="{{ old($field) }}" @if ($field === 'name') required minlength="2" @endif @if ($field === 'phone') type="tel" required @endif maxlength="150"></label>
    @endforeach
    <fieldset><legend>{{ __('forms.contact.services') }}</legend>
        @foreach ($services as $service)<label class="block"><input type="checkbox" name="service_ids[]" value="{{ $service['id'] }}" @checked(in_array($service['id'], old('service_ids', [])))> {{ $service['title'] }}</label>@endforeach
    </fieldset>
    <label>{{ __('forms.contact.message') }}<textarea class="block w-full" name="message" maxlength="5000">{{ old('message') }}</textarea></label>
    <input type="hidden" name="form_started_at" value="{{ now()->timestamp * 1000 }}">
    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
    <button class="rounded-sm bg-ink p-4 text-paper" type="submit">{{ __('forms.contact.submit') }}</button>
</form>
