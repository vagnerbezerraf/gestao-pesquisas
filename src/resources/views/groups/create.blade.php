@extends('layouts.app')

@section('title','New Group')

@section('content')
<h1>New Group</h1>
<form method="POST" action="{{ route('groups.store') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="emails" class="form-label">Emails (comma-separated)</label>
        <textarea id="emails" name="emails" class="form-control @error('emails') is-invalid @enderror">{{ old('emails') }}</textarea>
        @error('emails')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary">Create Group</button>
</form>
@endsection
