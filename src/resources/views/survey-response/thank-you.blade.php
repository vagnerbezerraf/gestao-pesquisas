@extends('layouts.app')

@section('title', 'Obrigado por responder')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h1 class="display-4 mb-4">Obrigado!</h1>
                    <p class="lead mb-4">Suas respostas para a pesquisa <strong>{{ $survey->title }}</strong> foram enviadas com sucesso.</p>
                    <p class="mb-5">Agradecemos a sua participação e feedback.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
<style>
    .card {
        border-radius: 1rem;
        border: none;
    }
    
    .card-body {
        padding: 3rem;
    }
    
    .display-4 {
        font-weight: 600;
        color: #0d6efd;
    }
    
    .lead {
        font-size: 1.25rem;
    }
</style>
@endpush
