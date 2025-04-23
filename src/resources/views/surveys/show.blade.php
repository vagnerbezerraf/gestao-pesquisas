@extends('layouts.app')

@section('title','Survey Detail')

@section('content')
<div class="mb-3">
    <h1>{{ $survey->title }}</h1>
    <p>{{ $survey->description }}</p>
    <p>Status: {{ ucfirst($survey->status) }}</p>
    <p>Created: {{ $survey->created_at->format('d/m/Y') }}</p>
</div>
<div class="mb-3">
    <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-secondary">Edit</a>
    <form action="{{ route('surveys.destroy', $survey) }}" method="POST" class="d-inline" x-data="{ confirmDelete: false }" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" x-text="confirmDelete ? 'Confirm?' : 'Delete'"></button>
    </form>
</div>
@endsection
