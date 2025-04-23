@extends('layouts.app')

@section('title','Groups')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Groups</h1>
    <a href="{{ route('groups.create') }}" class="btn btn-primary">New Group</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Emails</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($groups as $group)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $group->id }}</td>
            <td><a href="{{ route('groups.show', $group) }}">{{ $group->name }}</a></td>
            <td>{{ \Illuminate\Support\Str::limit($group->description,50) }}</td>
            <td>{{ count($group->emails ?? []) }}</td>
            <td>
                <a href="{{ route('groups.edit', $group) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form action="{{ route('groups.destroy', $group) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit" x-text="confirmDelete?'Confirm?':'Delete'"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
