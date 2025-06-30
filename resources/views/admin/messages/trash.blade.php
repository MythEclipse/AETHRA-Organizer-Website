@extends('layouts.admin')

@section('title', 'Trash - Pesan Masuk')
@section('content-header', 'Mailbox - Trash')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}">Inbox</a></li>
        <li class="breadcrumb-item active">Trash</li>
    </ol>
@endsection

@section('content')
<div class="row">
    {{-- Kolom Kiri: Sidebar Folder --}}
    <div class="col-md-3">
        <a href="{{ route('admin.messages.index') }}" class="btn btn-primary btn-block mb-3">Kembali ke Inbox</a>
        <div class="card">
            <div class="card-header"><h3 class="card-title">Folders</h3></div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item"><a href="{{ route('admin.messages.index') }}" class="nav-link"><i class="fas fa-inbox"></i> Inbox</a></li>
                    <li class="nav-item"><a href="{{ route('admin.messages.trash') }}" class="nav-link active"><i class="far fa-trash-alt"></i> Trash</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Daftar Pesan di Trash --}}
    <div class="col-md-9">
        <div class="card card-primary card-outline">
            <div class="card-header"><h3 class="card-title">Trash</h3></div>
            <div class="card-body p-0">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <tbody>
                            @forelse($conversation as $message)
                            <tr>
                                <td>{{ $message->user->name }}</td>
                                <td><b>{{ $message->subject }}</b> - {{ Str::limit(strip_tags($message->message), 40) }}</td>
                                <td>{{ $message->deleted_at->diffForHumans() }}</td>
                                <td>
                                    {{-- Form untuk Restore --}}
                                    <form action="{{ route('admin.messages.restore', $message->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-xs">Restore</button>
                                    </form>
                                    {{-- Form untuk Hapus Permanen --}}
                                    <form action="{{ route('admin.messages.forceDelete', $message->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus pesan ini SELAMANYA? Aksi ini tidak bisa dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Hapus Permanen</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center p-4">Folder trash kosong.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="mailbox-controls">
                    <div class="float-right py-2 px-3">{{ $conversation->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
