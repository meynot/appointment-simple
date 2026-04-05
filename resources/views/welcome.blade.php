<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600|cairo:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-900 antialiased {{ app()->isLocale('ar') ? 'locale-ar' : 'locale-en' }}">
        <div class="workspace-page">
            <div class="workspace-container workspace-stack">
                <div class="flex justify-end">
                    @include('layouts.language-switcher')
                </div>

                <section class="workspace-hero">
                    <div class="workspace-hero-inner">
                        <div>
                            <p class="workspace-eyebrow">{{ __('Appointments Platform') }}</p>
                            <h1 class="workspace-title">{{ __('Manage appointments, clients, and staff from one place.') }}</h1>
                            <p class="workspace-subtitle">{{ __('A focused operations workspace for scheduling, client records, and team access with full Arabic and English support.') }}</p>
                        </div>

                        <div class="workspace-actions">
                            @auth
                                <a href="{{ route('dashboard') }}" class="action-primary">{{ __('Go to Dashboard') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="action-primary">{{ __('Log in') }}</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="action-secondary">{{ __('Register') }}</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </section>

                <section class="summary-grid">
                    <div class="summary-card">
                        <p class="summary-label">{{ __('Users') }}</p>
                        <p class="summary-value">{{ \Illuminate\Support\Facades\Schema::hasTable('users') ? \App\Models\User::count() : 0 }}</p>
                        <p class="summary-note">{{ __('Manage admin and staff access with role-based authorization.') }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="summary-label">{{ __('Clients') }}</p>
                        <p class="summary-value">{{ \Illuminate\Support\Facades\Schema::hasTable('clients') ? \App\Models\Client::count() : 0 }}</p>
                        <p class="summary-note">{{ __('Keep contact details, case notes, and scheduling context organized.') }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="summary-label">{{ __('Appointments') }}</p>
                        <p class="summary-value">{{ \Illuminate\Support\Facades\Schema::hasTable('appointments') ? \App\Models\Appointment::count() : 0 }}</p>
                        <p class="summary-note">{{ __('Track pending and completed appointments in a single workflow.') }}</p>
                    </div>
                </section>

                <section class="content-card">
                    <div class="content-card-head">
                        <div>
                            <h2 class="content-card-title">{{ __('Start here') }}</h2>
                            <p class="content-card-copy">{{ __('Use the main areas below to move directly into the application.') }}</p>
                        </div>
                    </div>

                    <div class="grid gap-4 px-6 pb-6 md:grid-cols-3">
                        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="summary-card transition hover:-translate-y-0.5 hover:border-slate-300">
                            <p class="summary-label">{{ __('Dashboard') }}</p>
                            <p class="mt-3 text-xl font-semibold text-slate-900">{{ __('Overview and quick actions') }}</p>
                            <p class="summary-note">{{ __('Access the main operational overview and create records quickly.') }}</p>
                        </a>

                        <a href="{{ auth()->check() ? route('clients.index') : route('login') }}" class="summary-card transition hover:-translate-y-0.5 hover:border-slate-300">
                            <p class="summary-label">{{ __('Clients') }}</p>
                            <p class="mt-3 text-xl font-semibold text-slate-900">{{ __('Client records') }}</p>
                            <p class="summary-note">{{ __('Open and manage client profiles, notes, and linked appointments.') }}</p>
                        </a>

                        <a href="{{ auth()->check() ? route('appointments.index') : route('login') }}" class="summary-card transition hover:-translate-y-0.5 hover:border-slate-300">
                            <p class="summary-label">{{ __('Appointments') }}</p>
                            <p class="mt-3 text-xl font-semibold text-slate-900">{{ __('Scheduling board') }}</p>
                            <p class="summary-note">{{ __('Monitor appointment status and schedule new work items.') }}</p>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
