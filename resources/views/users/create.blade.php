<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create User') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('New Record') }}</p>
                        <h1 class="workspace-title">{{ __('Create a new user') }}</h1>
                        <p class="workspace-subtitle">{{ __('Set access, assign the correct role, and bring a new team member into the system cleanly.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('users.index') }}" class="action-secondary">{{ __('Back to Users') }}</a>
                    </div>
                </div>
            </section>

            <div class="form-layout">
                <aside class="form-aside">
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('What to prepare') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ __('Account setup') }}</p>
                        <p class="summary-note">{{ __('Provide a name, email, role, and initial password. Only admins can manage this area.') }}</p>
                    </div>
                </aside>

                <div class="form-card text-slate-900">
                    <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                        @csrf

                        @include('users._form', [
                            'user' => null,
                            'editing' => false,
                            'submitLabel' => __('Create User'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>