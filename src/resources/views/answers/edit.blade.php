@extends('layouts.app')

@section('title','Edit Answer')

@section('content')
<h1>Edit Answer #{{ $answer->id }}</h1>
<form method="POST" action="{{ route('answers.update', $answer) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="survey_id" class="form-label">Survey</label>
        <select id="survey_id" name="survey_id" class="form-select @error('survey_id') is-invalid @enderror" required>
            @foreach(App\Models\Survey::all() as $s)
                <option value="{{ $s->id }}" {{ $answer->survey_id==$s->id?'selected':'' }}>{{ $s->title }}</option>
            @endforeach
        </select>
        @error('survey_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="question_id" class="form-label">Question</label>
        <select id="question_id" name="question_id" class="form-select @error('question_id') is-invalid @enderror" required>
            @foreach(App\Models\Question::all() as $q)
                <option value="{{ $q->id }}" {{ $answer->question_id==$q->id?'selected':'' }}>{{ $q->text }}</option>
            @endforeach
        </select>
        @error('question_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="value" class="form-label">Value</label>
        <input id="value" type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', json_encode($answer->value)) }}" required>
        @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
