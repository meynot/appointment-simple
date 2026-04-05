<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Operations Overview') }}</p>
                        <h1 class="workspace-title">{{ __('Appointments command center') }}</h1>
                        <p class="workspace-subtitle">{{ __('Move between users, clients, and appointments from one shared workspace with clearer counts and faster entry points.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        @can('create', App\Models\Appointment::class)
                            <a href="{{ route('appointments.create') }}" class="action-primary">{{ __('Create Appointment') }}</a>
                        @endcan
                        @can('create', App\Models\Client::class)
                            <a href="{{ route('clients.create') }}" class="action-secondary">{{ __('Create Client') }}</a>
                        @endcan
                    </div>
                </div>
            </section>

            <section class="summary-grid">
                @can('viewAny', App\Models\User::class)
                    <div class="summary-card">
                        <p class="summary-label">{{ __('Users') }}</p>
                        <p class="summary-value">{{ \App\Models\User::count() }}</p>
                        <p class="summary-note">{{ __('Manage account records, roles, and access from one place.') }}</p>
                        <a href="{{ route('users.index') }}" class="mt-4 inline-flex items-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                {{ __('View Users') }}
                            </a>
                    </div>
                @endcan

                <div class="summary-card">
                    <p class="summary-label">{{ __('Clients') }}</p>
                    <p class="summary-value">{{ \App\Models\Client::count() }}</p>
                    <p class="summary-note">{{ __('Create, update, and review client contact details.') }}</p>
                    <a href="{{ route('clients.index') }}" class="mt-4 inline-flex items-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            {{ __('View Clients') }}
                        </a>
                </div>

                <div class="summary-card">
                    <p class="summary-label">{{ __('Appointments') }}</p>
                    <p class="summary-value">{{ \App\Models\Appointment::count() }}</p>
                    <p class="summary-note">{{ __('Track scheduled client work and monitor completion status.') }}</p>
                    <a href="{{ route('appointments.index') }}" class="mt-4 inline-flex items-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            {{ __('View Appointments') }}
                        </a>
                </div>
            </section>

            <section class="content-card">
                <div class="content-card-head">
                    <div>
                        <h3 class="content-card-title">{{ __('Quick actions') }}</h3>
                        <p class="content-card-copy">{{ __('Jump directly into the areas your team updates most often.') }}</p>
                    </div>
                </div>

                <div class="grid gap-4 px-6 pb-6 md:grid-cols-3">
                    @can('create', App\Models\User::class)
                        <a href="{{ route('users.create') }}" class="summary-card transition hover:-translate-y-0.5 hover:border-slate-300">
                            <p class="summary-label">{{ __('Admin') }}</p>
                            <p class="mt-3 text-xl font-semibold text-slate-900">{{ __('Create User') }}</p>
                            <p class="summary-note">{{ __('Add a new account and assign the right role from the start.') }}</p>
                        </a>
                    @endcan

                    <a href="{{ route('clients.create') }}" class="summary-card transition hover:-translate-y-0.5 hover:border-slate-300">
                        <p class="summary-label">{{ __('Clients') }}</p>
                        <p class="mt-3 text-xl font-semibold text-slate-900">{{ __('Create Client') }}</p>
                        <p class="summary-note">{{ __('Open a fresh client record with contact details and notes.') }}</p>
                    </a>

                    <a href="{{ route('appointments.create') }}" class="summary-card transition hover:-translate-y-0.5 hover:border-slate-300">
                        <p class="summary-label">{{ __('Schedule') }}</p>
                        <p class="mt-3 text-xl font-semibold text-slate-900">{{ __('Create Appointment') }}</p>
                        <p class="summary-note">{{ __('Schedule work immediately from the dashboard.') }}</p>
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
