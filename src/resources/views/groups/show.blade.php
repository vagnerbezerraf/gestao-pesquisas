@extends('layouts.app')

@section('title','Group Detail')

@section('content')
<div class="mb-3">
    <h1>{{ $group->name }}</h1>
    <p>{{ $group->description }}</p>
    <p><strong>Emails:</strong> {{ $group->emails ? implode(', ', $group->emails) : 'None' }}</p>
</div>
<div>
    <a href="{{ route('groups.edit', $group) }}" class="btn btn-secondary">Edit</a>
    <form action="{{ route('groups.destroy', $group) }}" method="POST" class="d-inline" x-data="{confirmDelete:false}" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete=true">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" x-text="confirmDelete?'Confirm?':'Delete'"></button>
    </form>
</div>
@endsection
