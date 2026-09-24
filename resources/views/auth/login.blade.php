<x-guest-layout title="Login">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900">Welcome back</h1>
        <p class="text-slate-500 mt-1">Sign in to your StayEase account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="input-modern mt-1.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-password-input id="password" class="mt-1.5" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</label>
        </div>
        <div class="flex items-center justify-between pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-brand-600 hover:text-brand-700 font-medium" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
            @endif
            <x-primary-button>{{ __('Log in') }}</x-primary-button>
        </div>
    </form>
    <p class="text-center text-sm text-slate-500 mt-6">
        Don't have an account? <a href="{{ route('register') }}" class="text-brand-600 font-semibold hover:text-brand-700">Register</a>
    </p>
</x-guest-layout>
