<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Clients') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Client Relations') }}</p>
                        <h1 class="workspace-title">{{ __('Clients workspace') }}</h1>
                        <p class="workspace-subtitle">{{ __('Keep contact information, case notes, and appointment volume visible in one calmer interface.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('clients.create') }}" class="action-primary">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 4a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 0110 4z" /></svg>
                            {{ __('Create Client') }}
                        </a>
                    </div>
                </div>
            </section>

            <section class="summary-grid">
                <div class="summary-card">
                    <p class="summary-label">{{ __('Client Count') }}</p>
                    <p class="summary-value">{{ $stats['total'] }}</p>
                    <p class="summary-note">{{ __('Total client records currently available to staff.') }}</p>
                </div>
                <div class="summary-card">
                    <p class="summary-label">{{ __('With Appointments') }}</p>
                    <p class="summary-value">{{ $stats['withAppointments'] }}</p>
                    <p class="summary-note">{{ __('Clients already linked to one or more scheduled entries.') }}</p>
                </div>
                <div class="summary-card">
                    <p class="summary-label">{{ __('Without Appointments') }}</p>
                    <p class="summary-value">{{ $stats['withoutAppointments'] }}</p>
                    <p class="summary-note">{{ __('Records still waiting for their first scheduled appointment.') }}</p>
                </div>
            </section>

            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            <section class="filter-panel space-y-4">
                <div>
                    <h3 class="content-card-title">{{ __('Search and filter') }}</h3>
                    <p class="content-card-copy">{{ __('Search contact details or isolate clients with and without appointments.') }}</p>
                </div>

                <form method="GET" action="{{ route('clients.index') }}" class="filter-grid">
                    <div>
                        <label for="client-search" class="field-label">{{ __('Search') }}</label>
                        <input id="client-search" name="search" type="text" value="{{ $filters['search'] }}" placeholder="{{ __('Search name, phone, or address') }}" class="field-input">
                    </div>

                    <div>
                        <label for="client-appointments" class="field-label">{{ __('Appointment State') }}</label>
                        <select id="client-appointments" name="appointments" class="field-select">
                            <option value="">{{ __('All clients') }}</option>
                            <option value="with" @selected($filters['appointments'] === 'with')>{{ __('With appointments') }}</option>
                            <option value="without" @selected($filters['appointments'] === 'without')>{{ __('Without appointments') }}</option>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="action-primary">{{ __('Apply Filters') }}</button>
                        <a href="{{ route('clients.index') }}" class="action-neutral">{{ __('Reset') }}</a>
                    </div>
                </form>

                @if($filters['search'] !== '' || $filters['appointments'] !== '')
                    <div class="chip-row">
                        @if($filters['search'] !== '')
                            <span class="filter-chip">{{ __('Search') }}: {{ $filters['search'] }}</span>
                        @endif
                        @if($filters['appointments'] !== '')
                            <span class="filter-chip">{{ __('Appointments') }}: {{ $filters['appointments'] === 'with' ? __('With appointments') : __('Without appointments') }}</span>
                        @endif
                    </div>
                @endif
            </section>

            <section class="content-card">
                <div class="content-card-head">
                    <div>
                        <h3 class="content-card-title">{{ __('Client directory') }}</h3>
                        <p class="content-card-copy">{{ __('Scan contact details and appointment volume before opening an individual record.') }}</p>
                    </div>

                    <a href="{{ route('clients.create') }}" class="action-neutral">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 4a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 0110 4z" /></svg>
                        {{ __('Add Client') }}
                    </a>
                </div>

                <div class="table-shell">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Appointments') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td>
                                        <div class="font-semibold text-slate-900">{{ $client->name }}</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">{{ __('Client file') }}</div>
                                    </td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->address ?: '—' }}</td>
                                    <td><span class="pill-neutral">{{ $client->appointments_count }}</span></td>
                                    <td>{{ $client->created_at->translatedFormat('M j, Y') }}</td>
                                    <td>
                                        <div class="flex items-center justify-end gap-4">
                                            <a href="{{ route('clients.show', $client) }}" class="table-link">{{ __('View') }}</a>
                                            <a href="{{ route('clients.edit', $client) }}" class="table-link">{{ __('Edit') }}</a>
                                            <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('{{ __('Delete this client?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="table-danger">{{ __('Delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        <p class="empty-title">{{ __('No clients yet') }}</p>
                                        <p class="empty-copy">{{ __('Create the first client record to start scheduling appointments and storing contact details.') }}</p>
                                        <div class="mt-6">
                                            <a href="{{ route('clients.create') }}" class="action-neutral">{{ __('Create Client') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{ $clients->links() }}
        </div>
    </div>
</x-app-layout>