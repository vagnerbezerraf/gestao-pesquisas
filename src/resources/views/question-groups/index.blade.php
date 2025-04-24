@extends('layouts.app')

@section('title','Question Groups')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Question Groups</h1>
    @can('create', App\Models\QuestionGroup::class)
        <a href="{{ route('question-groups.create') }}" class="btn btn-primary">New Question Group</a>
    @endcan
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($questionGroups as $questionGroup)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $questionGroup->id }}</td>
            <td><a href="{{ route('question-groups.show', $questionGroup) }}">{{ $questionGroup->name }}</a></td>
            <td>{{ \Illuminate\Support\Str::limit($questionGroup->description,50) }}</td>
            <td>
                @can('update', $questionGroup)
                    <a href="{{ route('question-groups.edit', $questionGroup) }}" class="btn btn-sm btn-secondary">Edit</a>
                @endcan
                @can('delete', $questionGroup)
                    <form action="{{ route('question-groups.destroy', $questionGroup) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit" x-text="confirmDelete ? 'Confirm?' : 'Delete'"></button>
                    </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
