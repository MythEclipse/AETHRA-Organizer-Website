<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-4">Paket yang Anda Pilih: {{ $paket->name }}</h3>

                    <div class="mb-6 p-4 border rounded-lg">
                        <p><strong>Harga:</strong> Rp {{ number_format($paket->price) }}</p>
                        <p class="mt-2"><strong>Fitur Termasuk:</strong></p>
                        <ul class="list-disc list-inside ml-4">
                            @foreach ($paket->fiturs as $fitur)
                                <li>{{ $fitur->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                        <div>
                            <x-input-label for="event_date" :value="__('Pilih Tanggal Acara')" />
                            <x-text-input id="event_date" class="block mt-1 w-full" type="date" name="event_date" :value="old('event_date')" required />
                            <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Buat Pesanan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
