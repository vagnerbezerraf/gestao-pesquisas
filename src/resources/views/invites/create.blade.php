@extends('layouts.app')

@section('title','New Invite')

@section('content')
<h1>New Invite</h1>
<form method="POST" action="{{ route('invites.store') }}">
    @csrf
    <div class="mb-3">
        <label for="survey_id" class="form-label">Survey</label>
        <select id="survey_id" name="survey_id" class="form-select @error('survey_id') is-invalid @enderror" required>
            @foreach(App\Models\Survey::all() as $s)
                <option value="{{ $s->id }}">{{ $s->title }}</option>
            @endforeach
        </select>
        @error('survey_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="group_id" class="form-label">Group (optional)</label>
        <select id="group_id" name="group_id" class="form-select" >
            <option value="">None</option>
            @foreach(App\Models\Group::all() as $g)
                <option value="{{ $g->id }}">{{ $g->name }}</option>
            @endforeach
        </select>
        @error('group_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary">Create Invite</button>
</form>
@endsection
