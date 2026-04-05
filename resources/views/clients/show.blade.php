<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Client Details') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Client Details') }}</p>
                        <h1 class="workspace-title">{{ $client->name }}</h1>
                        <p class="workspace-subtitle">{{ __('See contact information, notes, and appointment history in one client-centered record.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('appointments.create', ['client_id' => $client->id]) }}" class="action-secondary">{{ __('Create Appointment') }}</a>
                        <a href="{{ route('clients.edit', $client) }}" class="action-primary">{{ __('Edit Client') }}</a>
                    </div>
                </div>
            </section>

            <section class="detail-grid">
                <div class="detail-card">
                    <p class="detail-label">{{ __('Phone') }}</p>
                    <p class="detail-value">{{ $client->phone }}</p>
                </div>
                <div class="detail-card">
                    <p class="detail-label">{{ __('Appointments') }}</p>
                    <p class="detail-value">{{ $client->appointments->count() }}</p>
                </div>
                <div class="detail-card md:col-span-2">
                    <p class="detail-label">{{ __('Address') }}</p>
                    <p class="detail-value">{{ $client->address ?: __('No address provided.') }}</p>
                </div>
                <div class="detail-card md:col-span-2">
                    <p class="detail-label">{{ __('Notes') }}</p>
                    <p class="detail-value whitespace-pre-line">{{ $client->notes ?: __('No notes available.') }}</p>
                </div>
            </section>

            <section class="content-card">
                <div class="content-card-head">
                    <div>
                        <h3 class="content-card-title">{{ __('Appointments') }}</h3>
                        <p class="content-card-copy">{{ __('All scheduled entries linked to this client.') }}</p>
                    </div>

                    <a href="{{ route('appointments.create', ['client_id' => $client->id]) }}" class="action-neutral">{{ __('Add Appointment') }}</a>
                </div>

                <div class="table-shell">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->appointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="font-semibold text-slate-900">{{ $appointment->sequence_number }}</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">{{ __('Appointment') }}</div>
                                    </td>
                                    <td>{{ $appointment->appointment_date->translatedFormat('M j, Y g:i A') }}</td>
                                    <td>
                                        <span class="{{ $appointment->status === 'completed' ? 'pill-success' : 'pill-pending' }}">
                                            {{ $appointment->status === 'completed' ? __('Completed') : __('Pending') }}
                                        </span>
                                    </td>
                                    <td>{{ $appointment->creator->name }}</td>
                                    <td>
                                        <div class="flex items-center justify-end gap-4">
                                            <a href="{{ route('appointments.show', $appointment) }}" class="table-link">{{ __('View') }}</a>
                                            <a href="{{ route('appointments.edit', $appointment) }}" class="table-link">{{ __('Edit') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <p class="empty-title">{{ __('No appointments scheduled') }}</p>
                                        <p class="empty-copy">{{ __('Use the create action to schedule the first appointment for this client.') }}</p>
                                        <div class="mt-6">
                                            <a href="{{ route('appointments.create', ['client_id' => $client->id]) }}" class="action-neutral">{{ __('Create Appointment') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>