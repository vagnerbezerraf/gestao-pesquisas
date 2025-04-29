@extends('layouts.app')

@section('title','Pesquisas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Pesquisas</h1>
    @can('create', App\Models\Survey::class)
        <a href="{{ route('surveys.create') }}" class="btn btn-primary">Nova Pesquisa</a>
    @endcan
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Status</th>
            <th>Perguntas</th>
            <th>Criado em</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($surveys as $survey)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $survey->id }}</td>
            <td><a href="{{ route('surveys.show', $survey) }}">{{ $survey->title }}</a></td>
            <td>{{ $survey->status }}</td>
            <td>{{ $survey->questions_count }}</td>
            <td>{{ $survey->created_at->format('d/m/Y') }}</td>
            <td>
                @can('update', $survey)
                    <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-sm btn-secondary">Editar</a>
                @endcan
                @can('delete', $survey)
                    <form action="{{ route('surveys.destroy', $survey) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" x-text="confirmDelete ? 'Confirmar?' : 'Excluir'"></button>
                    </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
