@extends('layouts.app')

@section('title','View Question')

@section('content')
<div class="mb-3">
    <h1>{{ $question->text }}</h1>
    <p><strong>Type:</strong> {{ $question->type }}</p>
    <p><strong>Category:</strong> {{ $question->questionCategory->name ?? '' }}</p>
    @if($question->options)
        <p><strong>Options:</strong> {{ implode(', ', $question->options) }}</p>
    @endif
</div>
<div>
    @can('update', $question)
        <a href="{{ route('questions.edit', $question) }}" class="btn btn-secondary">Edit</a>
    @endcan
    @can('delete', $question)
        <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline" x-data="{ confirmDelete:false }" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete=true">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" x-text="confirmDelete?'Confirm?':'Delete'"></button>
        </form>
    @endcan
</div>
@endsection
