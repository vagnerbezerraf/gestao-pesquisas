@extends('layouts.app')

@section('title','Answers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Answers</h1>
    <a href="{{ route('answers.index') }}" class="btn btn-primary">Refresh</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Survey</th>
            <th>Question</th>
            <th>User</th>
            <th>Value</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($answers as $answer)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $answer->id }}</td>
            <td>{{ $answer->survey->title ?? '' }}</td>
            <td>{{ $answer->question->text ?? '' }}</td>
            <td>{{ $answer->user->name ?? 'Guest' }}</td>
            <td><pre>{{ json_encode($answer->value) }}</pre></td>
            <td>{{ $answer->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('answers.show', $answer) }}" class="btn btn-sm btn-secondary">View</a>
                <form action="{{ route('answers.destroy', $answer) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" x-text="confirmDelete ? 'Confirm?' : 'Delete'"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
