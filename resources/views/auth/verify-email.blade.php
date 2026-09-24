<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900">Verify your email</h1>
        <p class="text-slate-500 mt-2 text-sm">Click the link in your email, or request a new one below.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-medium">
            {{ __('A new verification link has been sent to your email.') }}
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center">{{ __('Resend Verification Email') }}</x-primary-button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2.5 text-sm text-slate-600 hover:text-slate-900 font-medium">{{ __('Log Out') }}</button>
        </form>
    </div>
</x-guest-layout>
