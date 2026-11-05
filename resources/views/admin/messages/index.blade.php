@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('content-header', 'Mailbox')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Inbox</li>
    </ol>
@endsection

@section('content')
    {{-- Elemen Toast Notifikasi (diletakkan di sini agar posisinya fixed di atas konten) --}}
    <div id="new-message-toast" class="toasts-top-right fixed" style="display: none; z-index: 1060;">
        <div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header"><strong class="mr-auto">Notifikasi</strong><button data-dismiss="toast" type="button"
                    class="ml-2 mb-1 close" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <div class="toast-body">Anda memiliki pesan baru! Halaman akan dimuat ulang.</div>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Sidebar Folder --}}
        <div class="col-md-3">
            <a href="#" class="btn btn-primary btn-block mb-3 disabled">Compose (Coming Soon)</a>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Folders</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.messages.index') }}"
                                class="nav-link {{ empty($currentFilter) ? 'active' : '' }}">
                                <i class="fas fa-inbox"></i> Inbox
                                @if ($unreadCount > 0)
                                    <span class="badge bg-primary float-right">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.messages.index', ['filter' => 'starred']) }}"
                                class="nav-link {{ ($currentFilter ?? '') == 'starred' ? 'active' : '' }}">
                                <i class="far fa-star text-warning"></i> Starred
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.messages.trash') }}" class="nav-link">
                                <i class="far fa-trash-alt"></i> Trash
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Pesan --}}
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Inbox</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search Mail">
                            <div class="input-group-append">
                                <div class="btn btn-primary"><i class="fas fa-search"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%;"></th> {{-- Checkbox --}}
                                    <th style="width: 5%;"></th> {{-- Bintang --}}
                                    <th style="width: 20%;">Pengirim</th>
                                    <th>Subjek</th>
                                    <th style="width: 15%;">Tanggal</th>
                                    <th style="width: 15%;">Aksi</th> {{-- <-- TAMBAHKAN KOLOM INI --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $message)
                                    <tr class="{{ !$message->is_read ? 'table-info' : '' }}">
                                        <td>
                                            <div class="icheck-primary"><input type="checkbox" value=""
                                                    id="check{{ $message->id }}"><label
                                                    for="check{{ $message->id }}"></label></div>
                                        </td>
                                        <td class="mailbox-star">
                                            <button class="btn btn-link btn-xs star-btn p-0" data-id="{{ $message->id }}"
                                                title="Tandai sebagai penting">
                                                <i
                                                    class="fas fa-star {{ $message->is_starred ? 'text-warning' : 'text-muted' }}"></i>
                                            </button>
                                        </td>
                                        <td class="mailbox-name">
                                            <a
                                                href="{{ route('admin.messages.show', $message) }}">{{ $message->user->name }}</a>
                                        </td>
                                        <td class="mailbox-subject">
                                            <a href="{{ route('admin.messages.show', $message) }}"
                                                class="{{ !$message->is_read ? 'font-weight-bold' : '' }} text-dark">
                                                <b>{{ $message->subject }}</b> -
                                                {{ Str::limit(strip_tags($message->message), 30) }}
                                            </a>
                                        </td>
                                        <td class="mailbox-date">{{ $message->created_at->diffForHumans() }}</td>

                                        {{-- DI SINILAH ANDA MELETAKKANNYA --}}
                                        <td>
                                            <a href="{{ route('admin.messages.show', $message) }}"
                                                class="btn btn-info btn-xs">
                                                <i class="fas fa-eye"></i> Baca
                                            </a>

                                            {{-- Form untuk memindahkan ke Trash --}}
                                            <form action="{{ route('admin.messages.destroy', $message->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Anda yakin ingin memindahkan pesan ini ke trash?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs">
                                                    <i class="far fa-trash-alt"></i> Trash
                                                </button>
                                            </form>
                                        </td>
                                        {{-- BATAS AKHIR --}}

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-4">Tidak ada pesan masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <div class="mailbox-controls">
                        <div class="float-right py-2 px-3">
                            @if ($messages->total() > 0)
                                {{ $messages->firstItem() }}-{{ $messages->lastItem() }}/{{ $messages->total() }}
                            @endif
                            <div class="btn-group">
                                {{ $messages->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- Diperlukan untuk styling checkbox iCheck --}}
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- LOGIKA UNTUK TOMBOL BINTANG (STAR) ---
            const starButtons = document.querySelectorAll('.star-btn');
            starButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const messageId = this.dataset.id;
                    const starIcon = this.querySelector('i');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    fetch(`/admin/conversations/${messageId}/toggle-star`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.is_starred) {
                                starIcon.classList.add('text-warning');
                                starIcon.classList.remove('text-muted');
                            } else {
                                starIcon.classList.add('text-muted');
                                starIcon.classList.remove('text-warning');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // --- LOGIKA UNTUK AUTO REFRESH / POLLING ---
            let currentUnreadCount = {{ $unreadCount }};
            const toastElement = document.getElementById('new-message-toast');

            function checkForNewMessages() {
                fetch("{{ route('admin.messages.checkNew') }}")
                    .then(response => response.json())
                    .then(data => {
                        if (data.unread_count > currentUnreadCount) {
                            toastElement.style.display = 'block';
                            setTimeout(() => location.reload(), 2500);
                        } else {
                            currentUnreadCount = data.unread_count;
                        }
                    })
                    .catch(error => console.error('Polling error:', error));
            }

            // Jalankan pengecekan setiap 30 detik
            setInterval(checkForNewMessages, 1000);
        });
    </script>
@endpush
