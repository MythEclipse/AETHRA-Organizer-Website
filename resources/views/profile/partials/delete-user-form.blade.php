<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition" data-modal-target="confirm-user-deletion-modal" data-modal-toggle="confirm-user-deletion-modal">
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <div id="confirm-user-deletion-modal" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-auto">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="flex items-center justify-between px-6 py-4 border-b dark:border-gray-700">
                    <h5 class="text-lg font-medium dark:text-gray-100">{{ __('Are you sure you want to delete your account?') }}</h5>
                    <button type="button" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300" data-modal-hide="confirm-user-deletion-modal" aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mt-4">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-red-500 focus:ring-red-500 @error('password', 'userDeletion') border-red-500 @enderror"
                            placeholder="{{ __('Password') }}"
                        />
                        @error('password', 'userDeletion')
                            <span class="text-red-600 dark:text-red-400 text-sm mt-1 block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-2 px-6 py-4 border-t dark:border-gray-700">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600" data-modal-hide="confirm-user-deletion-modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">{{ __('Delete Account') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Simple modal toggle for Tailwind (no dependencies)
    document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.getAttribute('data-modal-target'));
            if (modal) modal.classList.remove('hidden');
        });
    });
    document.querySelectorAll('[data-modal-hide]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.getAttribute('data-modal-hide'));
            if (modal) modal.classList.add('hidden');
        });
    });
</script>
