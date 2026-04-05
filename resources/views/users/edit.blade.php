<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit User') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('User Profile') }}</p>
                        <h1 class="workspace-title">{{ __('Edit :name', ['name' => $user->name]) }}</h1>
                        <p class="workspace-subtitle">{{ __('Update role, contact details, or reset password without leaving the management workspace.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('users.show', $user) }}" class="action-secondary">{{ __('View User') }}</a>
                        <a href="{{ route('users.create') }}" class="action-primary">{{ __('Create User') }}</a>
                    </div>
                </div>
            </section>

            <div class="form-layout">
                <aside class="form-aside">
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('Current Role') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ $user->role === 'admin' ? __('Admin') : __('Staff') }}</p>
                        <p class="summary-note">{{ __('Use this form to adjust access while preserving the existing password unless you intentionally replace it.') }}</p>
                    </div>
                </aside>

                <div class="form-card text-slate-900">
                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('users._form', [
                            'editing' => true,
                            'submitLabel' => 'Update User',
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>