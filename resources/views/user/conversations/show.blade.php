<x-user-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('user.conversations.index') }}" class="text-indigo-500 dark:text-indigo-400 hover:underline">Pesan Saya</a>
            <span class="text-gray-400 dark:text-gray-600 mx-2">/</span>
            Detail Percakapan
        </h2>
    </x-slot>

    <div class="border rounded-lg dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
        <div class="p-4 sm:p-6 border-b dark:border-gray-700">
            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $conversation->subject }}</h3>
        </div>

        <div class="p-4 sm:p-6 space-y-6">
            <div class="flex items-start gap-3">
                <img src="{{ $conversation->user->profile_photo_url }}" class="h-10 w-10 rounded-full object-cover flex-shrink-0" alt="user photo">
                <div class="w-full">
                    <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg rounded-tl-none">
                        <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">Anda</p>
                        <p class="text-gray-700 dark:text-gray-300 mt-1">{!! nl2br(e($conversation->message)) !!}</p>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $conversation->created_at->format('d M, H:i') }}</p>
                </div>
            </div>

            @foreach($conversation->replies as $reply)
                @if($reply->is_admin_reply)
                    <div class="flex items-start gap-3 justify-end">
                        <div class="w-full text-right">
                             <div class="inline-block p-3 bg-blue-600 text-white rounded-lg rounded-br-none text-left">
                                <p class="font-semibold text-sm">Admin Aethra</p>
                                <p class="mt-1">{!! nl2br(e($reply->message)) !!}</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $reply->created_at->format('d M, H:i') }}</p>
                        </div>
                        <img src="{{ asset('img/admin-avatar.png') }}" class="h-10 w-10 rounded-full object-cover flex-shrink-0 bg-white p-1" alt="admin photo">
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-user-dashboard-layout>
