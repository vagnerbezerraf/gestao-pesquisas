@extends('layouts.app')

@section('title','Invites')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Invites</h1>
    @can('create', App\Models\Invite::class)
        <a href="{{ route('invites.create') }}" class="btn btn-primary">New Invite</a>
    @endcan
</div>
<form method="GET" action="{{ route('invites.index') }}" class="mb-3 row g-2">
    <div class="col-auto">
        <select name="survey_id" class="form-select">
            <option value="">Todas Pesquisas</option>
            @foreach($surveys as $s)
                <option value="{{ $s->id }}" {{ request('survey_id') == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <select name="group_id" class="form-select">
            <option value="">Todos Grupos</option>
            @foreach($groups as $g)
                <option value="{{ $g->id }}" {{ request('group_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-secondary">Filter</button>
    </div>
</form>
<form id="bulkForm" method="POST">
    @csrf
    <button type="button" id="deleteSelected" class="btn btn-danger mb-3">Delete Selected</button>
    <button type="button" id="sendSelected" class="btn btn-success mb-3 ms-2">Send Selected</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th>
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
                <td><input type="checkbox" name="ids[]" value="{{ $invite->id }}" class="select-item"></td>
                <td>{{ $invite->id }}</td>
                <td>{{ $invite->survey->title }}</td>
                <td>{{ $invite->group->name ?? 'None' }}</td>
                <td>{{ $invite->email }}</td>
                <td>{{ ucfirst($invite->status) }}</td>
                <td>{{ $invite->sent_at?->format('d/m/Y H:i') }}</td>
                <td>{{ $invite->responded_at?->format('d/m/Y H:i') }}</td>
                <td>
                    @can('update', $invite)
                    @if($invite->status === 'pending')
                    <form action="{{ route('invites.send', $invite) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmSend ? $el.submit() : confirmSend = true">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" x-text="confirmSend ? 'Confirm Send' : 'Send'"></button>
                    </form>
                    @endif
                    @endcan
                    @can('view', $invite)
                        <a href="{{ route('invites.show', $invite) }}" class="btn btn-sm btn-secondary">View</a>
                    @endcan
                    @can('update', $invite)
                        <a href="{{ route('invites.edit', $invite) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan
                    @can('delete', $invite)
                        <form action="{{ route('invites.destroy', $invite) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" x-text="confirmDelete ? 'Confirm Delete' : 'Delete'"></button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</form>
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('deleteSelected').addEventListener('click', function() {
        let form = document.getElementById('bulkForm');
        form.action = '{{ route('invites.massDestroy') }}';
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            form.appendChild(methodInput);
        }
        methodInput.value = 'DELETE';
        form.submit();
    });
    document.getElementById('sendSelected').addEventListener('click', function() {
        let form = document.getElementById('bulkForm');
        form.action = '{{ route('invites.massSend') }}';
        let methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        form.submit();
    });
</script>
@endsection
