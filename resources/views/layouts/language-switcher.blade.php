@php($compact = $compact ?? false)

<div class="locale-switcher {{ $compact ? '' : 'w-fit' }}">
    @foreach (['ar' => __('Arabic'), 'en' => __('English')] as $locale => $label)
        <form method="POST" action="{{ route('locale.update') }}">
            @csrf
            <input type="hidden" name="locale" value="{{ $locale }}">
            <button
                type="submit"
                class="locale-switcher-button {{ app()->isLocale($locale) ? 'locale-switcher-button-active' : '' }}"
                aria-pressed="{{ app()->isLocale($locale) ? 'true' : 'false' }}"
            >
                {{ $label }}
            </button>
        </form>
    @endforeach
</div>