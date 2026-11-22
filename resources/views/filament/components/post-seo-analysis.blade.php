<div class="space-y-3" aria-live="polite">
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('These checks are suggestions, not a prediction of search rankings. Search engines may display different text.') }}</p>
    <div class="space-y-1 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
        <p class="text-xs text-gray-600 dark:text-gray-300">{{ __('Search result preview') }}</p>
        <p class="break-all text-xs text-gray-700 dark:text-gray-300">{{ $preview['url'] ?: __('Enter a slug to see the URL.') }}</p>
        <p class="break-words text-base font-medium text-primary-700 dark:text-primary-400">{{ $preview['title'] }}</p>
        <p class="break-words text-sm text-gray-700 dark:text-gray-300">{{ $preview['description'] }}</p>
    </div>
    <ul class="space-y-2 text-sm">
        @foreach ($checks as $check)
            <li class="flex items-start gap-2">
                <span class="font-medium {{ $check['level'] === 'good' ? 'text-success-700 dark:text-success-400' : ($check['level'] === 'warning' ? 'text-warning-700 dark:text-warning-400' : 'text-gray-700 dark:text-gray-300') }}">
                    {{ __($check['level'] === 'good' ? 'Present' : ($check['level'] === 'warning' ? 'Review' : 'Suggestion')) }}:
                </span>
                <span>{{ $check['message'] }}</span>
            </li>
        @endforeach
    </ul>
</div>
