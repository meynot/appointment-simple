<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Client') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Client Record') }}</p>
                        <h1 class="workspace-title">{{ __('Edit :name', ['name' => $client->name]) }}</h1>
                        <p class="workspace-subtitle">{{ __('Refine contact details, notes, and the profile data that staff rely on before scheduling.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('clients.show', $client) }}" class="action-secondary">{{ __('View Client') }}</a>
                        <a href="{{ route('clients.create') }}" class="action-primary">{{ __('Create Client') }}</a>
                    </div>
                </div>
            </section>

            <div class="form-layout">
                <aside class="form-aside">
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('Client Phone') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ $client->phone }}</p>
                        <p class="summary-note">{{ __('This value stays unique across clients and is often the fastest way to locate a record.') }}</p>
                    </div>
                </aside>

                <div class="form-card text-slate-900">
                    <form method="POST" action="{{ route('clients.update', $client) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('clients._form', [
                            'submitLabel' => __('Update Client'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>