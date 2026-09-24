<x-guest-layout title="Register">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900">Create account</h1>
        <p class="text-slate-500 mt-1">Join StayEase and find your perfect stay</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="input-modern mt-1.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="input-modern mt-1.5" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-password-input id="password" class="mt-1.5" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-password-input id="password_confirmation" class="mt-1.5" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="pt-2">
            <x-primary-button class="w-full justify-center">{{ __('Register') }}</x-primary-button>
        </div>
    </form>
    <p class="text-center text-sm text-slate-500 mt-6">
        Already registered? <a href="{{ route('login') }}" class="text-brand-600 font-semibold hover:text-brand-700">Log in</a>
    </p>
</x-guest-layout>
