@extends('layouts.app')

@section('title','Question Group Detail')

@section('content')
<div class="mb-3">
    <h1>{{ $questionGroup->name }}</h1>
    <p>{{ $questionGroup->description }}</p>
</div>
<div>
    <a href="{{ route('question-groups.edit', $questionGroup) }}" class="btn btn-secondary">Edit</a>
    <form action="{{ route('question-groups.destroy', $questionGroup) }}" method="POST" class="d-inline" x-data="{confirmDelete:false}" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete=true">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" x-text="confirmDelete?'Confirm?':'Delete'"></button>
    </form>
</div>
@endsection
