@extends('layouts.app')

@section('title','Answer Detail')

@section('content')
<div class="mb-3">
    <h1>Answer #{{ $answer->id }}</h1>
    <p><strong>Survey:</strong> {{ $answer->survey->title ?? '' }}</p>
    <p><strong>Question:</strong> {{ $answer->question->text ?? '' }}</p>
    <p><strong>User:</strong> {{ $answer->user->name ?? 'Guest' }}</p>
    <p><strong>Value:</strong> <pre>{{ json_encode($answer->value) }}</pre></p>
    <p><strong>Created At:</strong> {{ $answer->created_at->format('d/m/Y H:i') }}</p>
</div>
<a href="{{ route('answers.edit', $answer) }}" class="btn btn-secondary">Edit</a>
<form action="{{ route('answers.destroy', $answer) }}" method="POST" class="d-inline" x-data="{confirmDelete:false}" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete=true">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" x-text="confirmDelete?'Confirm?':'Delete'"></button>
</form>
@endsection
