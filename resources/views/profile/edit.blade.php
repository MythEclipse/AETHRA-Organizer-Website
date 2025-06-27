<x-user-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="space-y-6 bg-white dark:bg-gray-900 p-6 rounded-lg shadow">
        @include('profile.partials.update-profile-information-form')
        <hr class="my-6 border-gray-300 dark:border-gray-700">
        @include('profile.partials.update-password-form')
        <hr class="my-6 border-gray-300 dark:border-gray-700">
        @include('profile.partials.delete-user-form')
    </div>
</x-user-dashboard-layout>
