@extends('layouts.app')

@section('title','Register')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">Register</div>
      <div class="card-body">
        <form method="POST" action="{{ route('register.submit') }}">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmação de senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
