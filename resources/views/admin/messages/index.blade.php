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
    <div class="row">
        {{-- Kolom Kiri: Sidebar Folder --}}
        {{-- Kolom Kiri: Sidebar Folder --}}
        <div class="col-md-3">
            <a href="#" class="btn btn-primary btn-block mb-3 disabled">Compose (Coming Soon)</a>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Folders</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        {{-- Link ke Inbox (semua pesan) --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.messages.index') }}"
                                class="nav-link {{ empty($currentFilter) ? 'active' : '' }}">
                                <i class="fas fa-inbox"></i> Inbox
                                @if ($unreadCount > 0)
                                    <span class="badge bg-primary float-right">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                        {{-- Link ke Pesan Berbintang --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.messages.index', ['filter' => 'starred']) }}"
                                class="nav-link {{ $currentFilter == 'starred' ? 'active' : '' }}">
                                <i class="far fa-star text-warning"></i> Starred
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-muted">
                                <i class="far fa-trash-alt"></i> Trash
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Kita bisa tambahkan folder "Labels" seperti di contoh AdminLTE --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Labels</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle text-danger"></i>
                                Important
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle text-warning"></i>
                                Promotions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle text-primary"></i>
                                Social
                            </a>
                        </li>
                    </ul>
                </div>
            </div> --}}
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
                                <div class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="mailbox-controls">
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                                @forelse($conversations as $conversation)
                                    <tr class="{{ !$conversation->is_read ? 'font-weight-bold' : '' }}">
                                        <td>
                                            <div class="icheck-primary">
                                                <input type="checkbox" value="" id="check{{ $conversation->id }}">
                                                <label for="check{{ $conversation->id }}"></label>
                                            </div>
                                        </td>
                                        <td class="mailbox-star">
                                            <button class="btn btn-link btn-xs star-btn p-0" data-id="{{ $conversation->id }}"
                                                title="Tandai sebagai penting">
                                                @if ($conversation->is_starred)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            </button>
                                        </td>
                                        <td class="mailbox-name">
                                            <a
                                                href="{{ route('admin.messages.show', $conversation->id) }}">{{ $conversation->name }}</a>
                                        </td>
                                        <td class="mailbox-subject">
                                            <b>{{ $conversation->subject }}</b> -
                                            {{ Str::limit(strip_tags($conversation->message), 40) }}
                                        </td>
                                        <td class="mailbox-attachment"></td>
                                        <td class="mailbox-date">{{ $conversation->created_at->diffForHumans() }}</td>
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
                            {{ $conversations->firstItem() }}-{{ $conversations->lastItem() }}/{{ $conversations->total() }}
                            <div class="btn-group">
                                {{ $conversations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starButtons = document.querySelectorAll('.star-btn');

            starButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const messageId = this.dataset.id;
                    const starIcon = this.querySelector('i');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    fetch(`/admin/messages/${messageId}/toggle-star`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.is_starred) {
                                // Jika sekarang berbintang, ubah ikon menjadi penuh
                                starIcon.classList.remove('far');
                                starIcon.classList.add('fas');
                            } else {
                                // Jika tidak, ubah ikon menjadi kosong
                                starIcon.classList.remove('fas');
                                starIcon.classList.add('far');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endpush
@push('styles')
    {{-- Diperlukan untuk styling checkbox iCheck --}}
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush
