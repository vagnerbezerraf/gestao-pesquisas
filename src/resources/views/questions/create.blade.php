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
            <label for="question_category_id" class="form-label">Category</label>
            <select name="question_category_id" id="question_category_id" class="form-select @error('question_category_id') is-invalid @enderror" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('question_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('question_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="weight" class="form-label">Weight</label>
            <input type="number" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', 1) }}" required>
            @error('weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
