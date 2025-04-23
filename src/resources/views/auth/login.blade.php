@extends('layouts.app')

@section('title','Login')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="POST" action="{{ route('login.submit') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" class="form-check-label">Lembrar-me</label>
          </div>
          <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
