<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Appointment Details') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Appointment Details') }}</p>
                        <h1 class="workspace-title">{{ __('Appointment #:sequence', ['sequence' => $appointment->sequence_number]) }}</h1>
                        <p class="workspace-subtitle">{{ __('Review scheduling details, assigned client, status, and notes from a cleaner detail screen.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('appointments.create') }}" class="action-secondary">{{ __('Create Appointment') }}</a>
                        <a href="{{ route('appointments.edit', $appointment) }}" class="action-primary">{{ __('Edit Appointment') }}</a>
                    </div>
                </div>
            </section>

            <section class="detail-grid">
                <div class="detail-card">
                    <p class="detail-label">{{ __('Sequence Number') }}</p>
                    <p class="detail-value">{{ $appointment->sequence_number }}</p>
                </div>
                <div class="detail-card">
                    <p class="detail-label">{{ __('Status') }}</p>
                    <p class="detail-value">{{ $appointment->status === 'completed' ? __('Completed') : __('Pending') }}</p>
                </div>
                <div class="detail-card">
                    <p class="detail-label">{{ __('Client') }}</p>
                    <p class="detail-value">
                        <a href="{{ route('clients.show', $appointment->client) }}" class="underline decoration-slate-300 underline-offset-4 hover:decoration-slate-700">{{ $appointment->client->name }}</a>
                    </p>
                </div>
                <div class="detail-card">
                    <p class="detail-label">{{ __('Created By') }}</p>
                    <p class="detail-value">{{ $appointment->creator->name }}</p>
                </div>
                <div class="detail-card md:col-span-2">
                    <p class="detail-label">{{ __('Appointment Date') }}</p>
                    <p class="detail-value">{{ $appointment->appointment_date->translatedFormat('M j, Y g:i A') }}</p>
                </div>
                <div class="detail-card md:col-span-2">
                    <p class="detail-label">{{ __('Notes') }}</p>
                    <p class="detail-value whitespace-pre-line">{{ $appointment->notes ?: __('No notes available.') }}</p>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>