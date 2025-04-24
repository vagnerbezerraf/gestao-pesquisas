@extends('layouts.app')

@section('title','New Question')

@section('content')
@can('create', App\Models\Question::class)
    <form method="POST" action="{{ route('questions.store') }}">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label">Text</label>
            <input type="text" name="text" id="text" class="form-control @error('text') is-invalid @enderror" value="{{ old('text') }}" required>
            @error('text')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="text">Text</option>
                <option value="select">Select</option>
                <option value="radio">Radio</option>
                <option value="checkbox">Checkbox</option>
            </select>
            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="survey_id" class="form-label">Survey</label>
            <select name="survey_id" id="survey_id" class="form-select @error('survey_id') is-invalid @enderror" required>
                @foreach($surveys as $s)
                <option value="{{ $s->id }}">{{ $s->title }}</option>
                @endforeach
            </select>
            @error('survey_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3" x-data="{ hasOptions: false }">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="optionsToggle" x-model="hasOptions">
                <label class="form-check-label" for="optionsToggle">Has Options</label>
            </div>
            <template x-if="hasOptions">
                <textarea name="options" class="form-control mt-2" placeholder="Comma-separated options"></textarea>
            </template>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endcan
@endsection
