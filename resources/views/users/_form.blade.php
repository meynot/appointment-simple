<div class="form-grid">
    <div>
        <x-input-label for="name" :value="__('Name')" class="field-label" />
        <x-text-input id="name" name="name" type="text" class="field-input" :value="old('name', $user->name ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" :value="__('Email')" class="field-label" />
        <x-text-input id="email" name="email" type="email" class="field-input" :value="old('email', $user->email ?? '')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="role" :value="__('Role')" class="field-label" />
        <select id="role" name="role" class="field-select">
            @php($selectedRole = old('role', $user->role ?? 'user'))
            <option value="user" @selected($selectedRole === 'user')>{{ __('Staff') }}</option>
            <option value="admin" @selected($selectedRole === 'admin')>{{ __('Admin') }}</option>
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" :value="$editing ? __('New Password') : __('Password')" class="field-label" />
        <x-text-input id="password" name="password" type="password" class="field-input" :required="! $editing" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        @if($editing)
            <p class="field-help">{{ __('Leave blank to keep the current password.') }}</p>
        @endif
    </div>

    <div class="md:col-span-2">
        <x-input-label for="password_confirmation" :value="$editing ? __('Confirm New Password') : __('Confirm Password')" class="field-label" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="field-input" :required="! $editing" />
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-4">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ route('users.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Cancel') }}</a>
</div>