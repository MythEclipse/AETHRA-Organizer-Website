<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <nav class="space-y-1">
            <a href="{{ route('my-transactions') }}"
               class="block px-4 py-2 text-sm font-medium rounded-md
                      {{ request()->routeIs('my-transactions')
                         ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100'
                         : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <i class="fas fa-file-invoice-dollar w-6 mr-2 inline-block text-center"></i>
                Riwayat Transaksi
            </a>

            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 text-sm font-medium rounded-md
                      {{ request()->routeIs('profile.edit')
                         ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100'
                         : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <i class="fas fa-user-circle w-6 mr-2 inline-block text-center"></i>
                Profil Saya
            </a>

            <hr class="dark:border-gray-600 my-2">

            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="block px-4 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <i class="fas fa-sign-out-alt w-6 mr-2 inline-block text-center text-red-500"></i>
                    Keluar
                </a>
            </form>
        </nav>
    </div>
</div>
