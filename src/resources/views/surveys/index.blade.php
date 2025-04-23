@extends('layouts.app')

@section('title','Surveys')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Surveys</h1>
    <a href="{{ route('surveys.create') }}" class="btn btn-primary">New Survey</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($surveys as $survey)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $survey->id }}</td>
            <td><a href="{{ route('surveys.show', $survey) }}">{{ $survey->title }}</a></td>
            <td>{{ $survey->status }}</td>
            <td>{{ $survey->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form action="{{ route('surveys.destroy', $survey) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
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
