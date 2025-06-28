@extends('layouts.admin')

@section('title', 'Baca Pesan')
@section('content-header', 'Baca Pesan')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}">Inbox</a></li>
        <li class="breadcrumb-item active">Read Mail</li>
    </ol>
@endsection

{{-- ... (extends dan section header) ... --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">Percakapan: {{ $conversation->subject }}</h3>
            </div>
            <div class="card-body">
                <div class="direct-chat-messages" style="height: auto; min-height: 300px;">
                    <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{ $conversation->user->name }}</span>
                            <span class="direct-chat-timestamp float-right">{{ $conversation->created_at->format('d M H:i') }}</span>
                        </div>
                        <img class="direct-chat-img" src="{{ $conversation->user->profile_photo_url }}" alt="user image">
                        <div class="direct-chat-text">
                            {!! nl2br(e($conversation->message)) !!}
                        </div>
                    </div>

                    @foreach($conversation->replies as $reply)
                        @if($reply->is_admin_reply)
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Admin</span>
                                    <span class="direct-chat-timestamp float-left">{{ $reply->created_at->format('d M H:i') }}</span>
                                </div>
                                <img class="direct-chat-img" src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="admin image">
                                <div class="direct-chat-text bg-primary">
                                    {!! nl2br(e($reply->message)) !!}
                                </div>
                            </div>
                        @else
                             {{-- ... struktur sama seperti pesan awal ... --}}
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <form action="{{ route('admin.messages.storeReply', $conversation->id) }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Ketik balasan ..." class="form-control" required>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
