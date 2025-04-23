@extends('layouts.app')

@section('title','Invites')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Invites</h1>
    <a href="{{ route('invites.create') }}" class="btn btn-primary">New Invite</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Survey</th>
            <th>Group</th>
            <th>Email</th>
            <th>Status</th>
            <th>Sent At</th>
            <th>Responded At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invites as $invite)
        <tr x-data="{ confirmSend: false, confirmDelete: false }">
            <td>{{ $invite->id }}</td>
            <td>{{ $invite->survey->title }}</td>
            <td>{{ $invite->group->name ?? 'None' }}</td>
            <td>{{ $invite->email }}</td>
            <td>{{ ucfirst($invite->status) }}</td>
            <td>{{ $invite->sent_at?->format('d/m/Y H:i') }}</td>
            <td>{{ $invite->responded_at?->format('d/m/Y H:i') }}</td>
            <td>
                @if($invite->status === 'pending')
                <form action="{{ route('invites.send', $invite) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmSend ? $el.submit() : confirmSend = true">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success" x-text="confirmSend ? 'Confirm Send' : 'Send'"></button>
                </form>
                @endif
                <a href="{{ route('invites.show', $invite) }}" class="btn btn-sm btn-secondary">View</a>
                <a href="{{ route('invites.edit', $invite) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('invites.destroy', $invite) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" x-text="confirmDelete ? 'Confirm Delete' : 'Delete'"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
