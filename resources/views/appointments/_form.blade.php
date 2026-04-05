<div class="form-grid">
    <div>
        <x-input-label for="client_id" :value="__('Client')" class="field-label" />
        <select id="client_id" name="client_id" class="field-select" required>
            <option value="">Select a client</option>
            @php($selectedClient = old('client_id', $appointment->client_id ?? $selectedClientId ?? null))
            @foreach($clients as $client)
                <option value="{{ $client->id }}" @selected((string) $selectedClient === (string) $client->id)>{{ $client->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="appointment_date" :value="__('Appointment Date')" class="field-label" />
        <x-text-input id="appointment_date" name="appointment_date" type="datetime-local" class="field-input" :value="old('appointment_date', isset($appointment) ? $appointment->appointment_date->format('Y-m-d\TH:i') : '')" required />
        <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" :value="__('Status')" class="field-label" />
        <select id="status" name="status" class="field-select" required>
            @php($selectedStatus = old('status', $appointment->status ?? 'pending'))
            <option value="pending" @selected($selectedStatus === 'pending')>Pending</option>
            <option value="completed" @selected($selectedStatus === 'completed')>Completed</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="notes" :value="__('Notes')" class="field-label" />
        <textarea id="notes" name="notes" rows="5" class="field-textarea">{{ old('notes', $appointment->notes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-4">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('appointments.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Cancel') }}</a>
</div>