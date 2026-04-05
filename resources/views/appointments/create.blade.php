<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Appointment') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Schedule Work') }}</p>
                        <h1 class="workspace-title">{{ __('Create an appointment') }}</h1>
                        <p class="workspace-subtitle">{{ __('Assign a client, set the scheduled date, and capture operational notes before the case begins.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('appointments.index') }}" class="action-secondary">{{ __('Back to Appointments') }}</a>
                    </div>
                </div>
            </section>

            <div class="form-layout">
                <aside class="form-aside">
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('Workflow') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ __('Pending by default') }}</p>
                        <p class="summary-note">{{ __('Create the appointment as pending, then mark it completed when the work is finished.') }}</p>
                    </div>
                </aside>

                <div class="form-card text-slate-900">
                    <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                        @csrf

                        @include('appointments._form', [
                            'appointment' => null,
                            'submitLabel' => __('Create Appointment'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>