<x-user-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Transaksi Saya') }}
        </h2>
    </x-slot>

    {{-- Konten utama ditempatkan langsung di sini --}}
    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="text-lg font-semibold mb-4">Daftar Pesanan Anda</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            {{-- ... Isi tabel sama seperti sebelumnya ... --}}
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tgl Acara</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($transaksis as $transaksi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->transaction_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->paket->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->event_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($transaksi->status == 'PENDING') bg-yellow-100 text-yellow-800 @endif
                                @if($transaksi->status == 'PAID' || $transaksi->status == 'SUCCESS') bg-green-100 text-green-800 @endif
                                @if($transaksi->status == 'CANCELLED' || $transaksi->status == 'FAILED') bg-red-100 text-red-800 @endif
                            ">
                                {{ $transaksi->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">Anda belum memiliki transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $transaksis->links() }}
    </div>

</x-user-dashboard-layout>
