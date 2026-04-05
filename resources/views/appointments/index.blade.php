<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Appointments') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Scheduling Board') }}</p>
                        <h1 class="workspace-title">{{ __('Appointments workspace') }}</h1>
                        <p class="workspace-subtitle">{{ __('Track scheduled work, move cases toward completion, and create new appointments from a stronger primary action.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('appointments.create') }}" class="action-primary">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 4a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 0110 4z" /></svg>
                            {{ __('Create Appointment') }}
                        </a>
                    </div>
                </div>
            </section>

            <section class="summary-grid">
                <div class="summary-card">
                    <p class="summary-label">{{ __('Appointments') }}</p>
                    <p class="summary-value">{{ $stats['total'] }}</p>
                    <p class="summary-note">{{ __('Total appointments stored across the system.') }}</p>
                </div>
                <div class="summary-card">
                    <p class="summary-label">{{ __('Pending') }}</p>
                    <p class="summary-value">{{ $stats['pending'] }}</p>
                    <p class="summary-note">{{ __('Work items still in progress or waiting to be completed.') }}</p>
                </div>
                <div class="summary-card">
                    <p class="summary-label">{{ __('Completed') }}</p>
                    <p class="summary-value">{{ $stats['completed'] }}</p>
                    <p class="summary-note">{{ __('Appointments already marked as finished.') }}</p>
                </div>
            </section>

            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            <section class="filter-panel space-y-4">
                <div>
                    <h3 class="content-card-title">{{ __('Search and filter') }}</h3>
                    <p class="content-card-copy">{{ __('Search by sequence, client, creator, or notes, then narrow the schedule by status or client.') }}</p>
                </div>

                <form method="GET" action="{{ route('appointments.index') }}" class="filter-grid-wide">
                    <div>
                        <label for="appointment-search" class="field-label">{{ __('Search') }}</label>
                        <input id="appointment-search" name="search" type="text" value="{{ $filters['search'] }}" placeholder="{{ __('Search sequence, client, creator, or notes') }}" class="field-input">
                    </div>

                    <div>
                        <label for="appointment-status" class="field-label">{{ __('Status') }}</label>
                        <select id="appointment-status" name="status" class="field-select">
                            <option value="">{{ __('All statuses') }}</option>
                            <option value="pending" @selected($filters['status'] === 'pending')>{{ __('Pending') }}</option>
                            <option value="completed" @selected($filters['status'] === 'completed')>{{ __('Completed') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="appointment-client" class="field-label">{{ __('Client') }}</label>
                        <select id="appointment-client" name="client_id" class="field-select">
                            <option value="">{{ __('All clients') }}</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" @selected((string) $filters['client_id'] === (string) $client->id)>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="action-primary">{{ __('Apply Filters') }}</button>
                        <a href="{{ route('appointments.index') }}" class="action-neutral">{{ __('Reset') }}</a>
                    </div>
                </form>

                @if($filters['search'] !== '' || $filters['status'] !== '' || $filters['client_id'])
                    <div class="chip-row">
                        @if($filters['search'] !== '')
                            <span class="filter-chip">{{ __('Search') }}: {{ $filters['search'] }}</span>
                        @endif
                        @if($filters['status'] !== '')
                            <span class="filter-chip">{{ __('Status') }}: {{ __($filters['status'] === 'pending' ? 'Pending' : 'Completed') }}</span>
                        @endif
                        @if($filters['client_id'])
                            <span class="filter-chip">{{ __('Client') }}: {{ $clients->firstWhere('id', $filters['client_id'])?->name }}</span>
                        @endif
                    </div>
                @endif
            </section>

            <section class="content-card">
                <div class="content-card-head">
                    <div>
                        <h3 class="content-card-title">{{ __('Schedule list') }}</h3>
                        <p class="content-card-copy">{{ __('Review client, date, and status at a glance before opening the full appointment.') }}</p>
                    </div>

                    <a href="{{ route('appointments.create') }}" class="action-neutral">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 4a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 0110 4z" /></svg>
                        {{ __('Add Appointment') }}
                    </a>
                </div>

                <div class="table-shell">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Client') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="font-semibold text-slate-900">{{ $appointment->sequence_number }}</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">{{ __('Sequence') }}</div>
                                    </td>
                                    <td>{{ $appointment->client->name }}</td>
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
                                            <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('{{ __('Delete this appointment?') }}');">
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
                                        <p class="empty-title">{{ __('No appointments scheduled') }}</p>
                                        <p class="empty-copy">{{ __('Create a new appointment to start building the active schedule.') }}</p>
                                        <div class="mt-6">
                                            <a href="{{ route('appointments.create') }}" class="action-neutral">{{ __('Create Appointment') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{ $appointments->links() }}
        </div>
    </div>
</x-app-layout>