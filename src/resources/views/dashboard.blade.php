@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Pesquisas</h5>
                    <p class="card-text">{{ array_sum($surveysCountByStatus) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Perguntas</h5>
                    <p class="card-text">{{ $questionsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Convites</h5>
                    <p class="card-text">{{ $invitesCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <canvas id="surveyStatusChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('surveyStatusChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! json_encode(array_keys($surveysCountByStatus)) !!},
        datasets: [{
            data: {!! json_encode(array_values($surveysCountByStatus)) !!},
            backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
@endpush
