<x-app-layout>
    {{-- Kita teruskan slot header dari halaman anak ke layout utama --}}
    <x-slot name="header">
        {{ $header }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">

                {{-- Kolom Kiri: Sidebar Menu Pengguna --}}
                {{-- <div class="w-full md:w-1/4"> --}}
                    {{-- File sidebar ini tidak perlu diubah --}}
                    {{-- @include('layouts.partials.user-sidebar') --}}
                {{-- </div> --}}

                {{-- Kolom Kanan: Konten Utama --}}
                <div class="w-full md:w-3/4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{-- Di sinilah konten utama dari halaman anak akan ditempatkan --}}
                            {{ $slot }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
