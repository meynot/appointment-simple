<div class="form-grid">
    <div>
        <x-input-label for="name" :value="__('Name')" class="field-label" />
        <x-text-input id="name" name="name" type="text" class="field-input" :value="old('name', $client->name ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="phone" :value="__('Phone')" class="field-label" />
        <x-text-input id="phone" name="phone" type="text" class="field-input" :value="old('phone', $client->phone ?? '')" required />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="address" :value="__('Address')" class="field-label" />
        <x-text-input id="address" name="address" type="text" class="field-input" :value="old('address', $client->address ?? '')" />
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="notes" :value="__('Notes')" class="field-label" />
        <textarea id="notes" name="notes" rows="5" class="field-textarea">{{ old('notes', $client->notes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-4">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('clients.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Cancel') }}</a>
</div>