<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Account Settings') }}</p>
                        <h1 class="workspace-title">{{ __('Manage your profile') }}</h1>
                        <p class="workspace-subtitle">{{ __('Update your identity, rotate your password, and control account safety from the same visual system as the rest of the app.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('dashboard') }}" class="action-secondary">{{ __('Back to Dashboard') }}</a>
                    </div>
                </div>
            </section>

            <div class="grid gap-6 xl:grid-cols-[0.85fr_1.45fr]">
                <aside class="form-aside">
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('Signed In As') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="summary-note">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="form-note-card">
                        <p class="summary-label">{{ __('Role') }}</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ auth()->user()->role === 'admin' ? __('Admin') : __('Staff') }}</p>
                        <p class="summary-note">{{ __('Your permissions in the application are tied to this role.') }}</p>
                    </div>
                </aside>

                <div class="workspace-stack">
                    <div class="form-card">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="form-card border-rose-200/70 bg-rose-50/50">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
