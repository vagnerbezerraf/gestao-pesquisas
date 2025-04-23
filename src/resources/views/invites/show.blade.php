@extends('layouts.app')

@section('title','Invite Detail')

@section('content')
<div class="mb-3">
    <h1>Invite #{{ $invite->id }}</h1>
    <p><strong>Survey:</strong> {{ $invite->survey->title }}</p>
    <p><strong>Group:</strong> {{ $invite->group->name ?? 'None' }}</p>
    <p><strong>Email:</strong> {{ $invite->email }}</p>
    <p><strong>Token:</strong> <code>{{ $invite->token }}</code></p>
    <p><strong>Status:</strong> {{ ucfirst($invite->status) }}</p>
    <p><strong>Sent At:</strong> {{ $invite->sent_at?->format('d/m/Y H:i') ?? 'Not sent' }}</p>
    <p><strong>Responded At:</strong> {{ $invite->responded_at?->format('d/m/Y H:i') ?? 'Not responded' }}</p>
</div>
<div class="mb-3">
    @if($invite->status === 'pending')
    <form action="{{ route('invites.send', $invite) }}" method="POST" class="d-inline" x-data="{confirmSend:false}" x-on:submit.prevent="confirmSend ? $el.submit() : confirmSend=true">
        @csrf
        <button type="submit" class="btn btn-success" x-text="confirmSend ? 'Confirm Send' : 'Send'"></button>
    </form>
    @endif
    <a href="{{ route('invites.edit', $invite) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('invites.destroy', $invite) }}" method="POST" class="d-inline" x-data="{confirmDelete:false}" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete=true">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" x-text="confirmDelete?'Confirm Delete':'Delete'"></button>
    </form>
</div>
@endsection
