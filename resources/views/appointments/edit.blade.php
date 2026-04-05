<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Appointment') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Scheduled Entry') }}</p>
                        <h1 class="workspace-title">{{ __('Edit appointment #:sequence', ['sequence' => $appointment->sequence_number]) }}</h1>
                        <p class="workspace-subtitle">{{ __('Adjust status, reschedule the date, or reassign the client relationship without leaving the schedule board.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('appointments.show', $appointment) }}" class="action-secondary">{{ __('View Appointment') }}</a>
                        <a href="{{ route('appointments.create') }}" class="action-primary">{{ __('Create Appointment') }}</a>
                    </div>
                </div>
            </section>

            <div class="form-layout">
                <aside class="form-aside">
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('Current Status') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ $appointment->status === 'completed' ? __('Completed') : __('Pending') }}</p>
                        <p class="summary-note">{{ __('Use this screen to reflect schedule changes and outcome updates as work progresses.') }}</p>
                    </div>
                </aside>

                <div class="form-card text-slate-900">
                    <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('appointments._form', [
                            'selectedClientId' => null,
                            'submitLabel' => __('Update Appointment'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>