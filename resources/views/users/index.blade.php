<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Users') }}</h2>
    </x-slot>

    <div class="workspace-page">
        <div class="workspace-container workspace-stack">
            <section class="workspace-hero">
                <div class="workspace-hero-inner">
                    <div>
                        <p class="workspace-eyebrow">{{ __('Access Control') }}</p>
                        <h1 class="workspace-title">{{ __('Users workspace') }}</h1>
                        <p class="workspace-subtitle">{{ __('Manage staff access, track roles, and keep the team directory clean with a clearer control surface.') }}</p>
                    </div>

                    <div class="workspace-actions">
                        <a href="{{ route('users.create') }}" class="action-primary">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 4a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 0110 4z" /></svg>
                            {{ __('Create User') }}
                        </a>
                    </div>
                </div>
            </section>

            <section class="summary-grid">
                <div class="summary-card">
                    <p class="summary-label">{{ __('Directory Size') }}</p>
                    <p class="summary-value">{{ $stats['total'] }}</p>
                    <p class="summary-note">{{ __('Total user accounts currently in the system.') }}</p>
                </div>
                <div class="summary-card">
                    <p class="summary-label">{{ __('Administrators') }}</p>
                    <p class="summary-value">{{ $stats['admins'] }}</p>
                    <p class="summary-note">{{ __('Accounts with full user-management access.') }}</p>
                </div>
                <div class="summary-card">
                    <p class="summary-label">{{ __('Staff') }}</p>
                    <p class="summary-value">{{ $stats['staff'] }}</p>
                    <p class="summary-note">{{ __('Operational users who can manage clients and appointments.') }}</p>
                </div>
            </section>

            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="flash-error">{{ session('error') }}</div>
            @endif

            <section class="filter-panel space-y-4">
                <div>
                    <h3 class="content-card-title">{{ __('Search and filter') }}</h3>
                    <p class="content-card-copy">{{ __('Find users by name or email, then narrow the list by role.') }}</p>
                </div>

                <form method="GET" action="{{ route('users.index') }}" class="filter-grid">
                    <div>
                        <label for="user-search" class="field-label">{{ __('Search') }}</label>
                        <input id="user-search" name="search" type="text" value="{{ $filters['search'] }}" placeholder="{{ __('Search name or email') }}" class="field-input">
                    </div>

                    <div>
                        <label for="user-role" class="field-label">{{ __('Role') }}</label>
                        <select id="user-role" name="role" class="field-select">
                            <option value="">{{ __('All roles') }}</option>
                            <option value="admin" @selected($filters['role'] === 'admin')>{{ __('Admin') }}</option>
                            <option value="user" @selected($filters['role'] === 'user')>{{ __('Staff') }}</option>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="action-primary">{{ __('Apply Filters') }}</button>
                        <a href="{{ route('users.index') }}" class="action-neutral">{{ __('Reset') }}</a>
                    </div>
                </form>

                @if($filters['search'] !== '' || $filters['role'] !== '')
                    <div class="chip-row">
                        @if($filters['search'] !== '')
                            <span class="filter-chip">{{ __('Search') }}: {{ $filters['search'] }}</span>
                        @endif
                        @if($filters['role'] !== '')
                            <span class="filter-chip">{{ __('Role') }}: {{ __($filters['role'] === 'user' ? 'Staff' : 'Admin') }}</span>
                        @endif
                    </div>
                @endif
            </section>

            <section class="content-card">
                <div class="content-card-head">
                    <div>
                        <h3 class="content-card-title">{{ __('Team accounts') }}</h3>
                        <p class="content-card-copy">{{ __('Review permissions, inspect user records, and keep user roles current.') }}</p>
                    </div>

                    <a href="{{ route('users.create') }}" class="action-neutral">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 4a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 0110 4z" /></svg>
                        {{ __('Add User') }}
                    </a>
                </div>

                <div class="table-shell">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                                        <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">{{ __('User record') }}</div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="{{ $user->role === 'admin' ? 'pill-admin' : 'pill-user' }}">{{ $user->role === 'admin' ? __('Admin') : __('Staff') }}</span>
                                    </td>
                                    <td>{{ $user->created_at->translatedFormat('M j, Y') }}</td>
                                    <td>
                                        <div class="flex items-center justify-end gap-4">
                                            <a href="{{ route('users.show', $user) }}" class="table-link">{{ __('View') }}</a>
                                            <a href="{{ route('users.edit', $user) }}" class="table-link">{{ __('Edit') }}</a>
                                            @if(! auth()->user()->is($user))
                                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('{{ __('Delete this user?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="table-danger">{{ __('Delete') }}</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <p class="empty-title">{{ __('No users yet') }}</p>
                                        <p class="empty-copy">{{ __('Start by creating the first user account for your team.') }}</p>
                                        <div class="mt-6">
                                            <a href="{{ route('users.create') }}" class="action-neutral">{{ __('Create User') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>