<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-900">{{ __('Profile') }}</h2>
    </x-slot>

    <div class="px-4 py-8 space-y-6 max-w-3xl mx-auto">
        <div class="card p-6 sm:p-8 animate-on-scroll">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="card p-6 sm:p-8 animate-on-scroll">
            @include('profile.partials.update-password-form')
        </div>
        <div class="card p-6 sm:p-8 animate-on-scroll">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
