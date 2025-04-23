@extends('layouts.app')

@section('title','Questions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Questions</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary">New Question</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Text</th>
            <th>Type</th>
            <th>Survey</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($questions as $question)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $question->id }}</td>
            <td><a href="{{ route('questions.show', $question) }}">{{ $question->text }}</a></td>
            <td>{{ $question->type }}</td>
            <td>{{ $question->survey->title ?? '' }}</td>
            <td>
                <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" x-text="confirmDelete ? 'Confirm?' : 'Delete'"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
