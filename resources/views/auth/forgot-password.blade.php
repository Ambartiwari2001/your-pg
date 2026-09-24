<x-guest-layout title="Forgot Password">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900">Forgot password?</h1>
        <p class="text-slate-500 mt-2 text-sm">Enter your email and we'll send you a reset link.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="input-modern mt-1.5" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <x-primary-button class="w-full justify-center">{{ __('Email Password Reset Link') }}</x-primary-button>
    </form>
</x-guest-layout>
