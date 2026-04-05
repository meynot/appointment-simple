<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('User Details') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('User Details') }}</p>
                        <h1 class="workspace-title">{{ $user->name }}</h1>
                        <p class="workspace-subtitle">{{ __('Inspect account identity, role assignment, and creation details from a more structured detail view.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('users.create') }}" class="action-secondary">{{ __('Create User') }}</a>
                        <a href="{{ route('users.edit', $user) }}" class="action-primary">{{ __('Edit User') }}</a>
                    </div>
                </div>
            </section>

            <section class="detail-grid">
                <div class="detail-card">
                    <p class="detail-label">{{ __('Name') }}</p>
                    <p class="detail-value">{{ $user->name }}</p>
                </div>
                <div class="detail-card">
                    <p class="detail-label">{{ __('Email') }}</p>
                    <p class="detail-value">{{ $user->email }}</p>
                </div>
                <div class="detail-card">
                    <p class="detail-label">{{ __('Role') }}</p>
                    <p class="detail-value">{{ $user->role === 'admin' ? __('Admin') : __('Staff') }}</p>
                </div>
                <div class="detail-card">
                    <p class="detail-label">{{ __('Created') }}</p>
                    <p class="detail-value">{{ $user->created_at->translatedFormat('M j, Y g:i A') }}</p>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>