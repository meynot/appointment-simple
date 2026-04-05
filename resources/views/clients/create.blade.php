<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Client') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('New Client') }}</p>
                        <h1 class="workspace-title">{{ __('Create a client record') }}</h1>
                        <p class="workspace-subtitle">{{ __('Capture contact information, address details, and contextual notes before scheduling work.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('clients.index') }}" class="action-secondary">{{ __('Back to Clients') }}</a>
                    </div>
                </div>
            </section>

            <div class="form-layout">
                <aside class="form-aside">
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('Recommended') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ __('Capture reliable contact data') }}</p>
                        <p class="summary-note">{{ __('Phone number uniqueness helps avoid duplicate records and keeps the scheduling flow cleaner.') }}</p>
                    </div>
                </aside>

                <div class="form-card text-slate-900">
                    <form method="POST" action="{{ route('clients.store') }}" class="space-y-6">
                        @csrf

                        @include('clients._form', [
                            'client' => null,
                            'submitLabel' => __('Create Client'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>