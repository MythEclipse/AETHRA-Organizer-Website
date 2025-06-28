@extends('layouts.admin')

@section('title', 'Detail Percakapan')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center">
        <span>Detail Percakapan</span>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Inbox
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Kita gunakan komponen Direct Chat dari AdminLTE --}}
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <strong>Subjek:</strong> {{ $conversation->subject }}
                </h3>
            </div>

            <div class="card-body">
                {{-- Area untuk menampilkan semua pesan --}}
                <div class="direct-chat-messages" style="height: auto; min-height: 400px;">

                    <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{ $conversation->user->name }}</span>
                            <span class="direct-chat-timestamp float-right">{{ $conversation->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <img class="direct-chat-img" src="{{ $conversation->user->profile_photo_url }}" alt="user image">
                        <div class="direct-chat-text">
                            {!! nl2br(e($conversation->message)) !!}
                        </div>
                    </div>

                    {{-- Loop untuk menampilkan semua balasan --}}
                    @foreach($conversation->replies as $reply)
                        @if($reply->is_admin_reply)
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Admin</span>
                                    <span class="direct-chat-timestamp float-left">{{ $reply->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <img class="direct-chat-img" src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="admin image">
                                <div class="direct-chat-text bg-primary">
                                    {!! nl2br(e($reply->message)) !!}
                                </div>
                            </div>
                        @else
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ $reply->user->name }}</span>
                                    <span class="direct-chat-timestamp float-right">{{ $reply->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <img class="direct-chat-img" src="{{ $reply->user->profile_photo_url }}" alt="user image">
                                <div class="direct-chat-text">
                                    {!! nl2br(e($reply->message)) !!}
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            <div class="card-footer">
                <form action="{{ route('admin.messages.reply', $conversation->id) }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Ketik balasan ..." class="form-control @error('message') is-invalid @enderror" required>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                        </span>
                    </div>
                     @error('message')
                        <span class="text-danger text-sm">{{ $conversation }}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Menambahkan sedikit style agar chat box tidak terlalu pendek --}}
<style>
    .direct-chat-messages {
        height: 50vh !important;
    }
</style>
@endpush
