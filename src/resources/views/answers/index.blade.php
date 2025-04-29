@extends('layouts.app')

@section('title','Respostas')

@section('content')
<div class="mb-4">
    <h1>Respostas</h1>
    <form method="GET" action="{{ route('answers.index') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="survey_id" class="form-label">Pesquisa</label>
            <select id="survey_id" name="survey_id" class="form-select">
                <option value="">Todas</option>
                @foreach(
                    $surveys as $id => $title
                )
                    <option value="{{ $id }}" {{ request('survey_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="question_id" class="form-label">Pergunta</label>
            <select id="question_id" name="question_id" class="form-select">
                <option value="">Todas</option>
                @foreach(
                    $questions as $id => $text
                )
                    <option value="{{ $id }}" {{ request('question_id') == $id ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('answers.index') }}" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </form>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pesquisa</th>
            <th>Pergunta</th>
            <th>Usuário</th>
            <th>Valor</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($answers as $answer)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $answer->id }}</td>
            <td>{{ $answer->survey->title ?? '' }}</td>
            <td>{{ $answer->question->text ?? '' }}</td>
            <td>{{ $answer->user->name ?? 'Convidado' }}</td>
            <td>{{ is_array($answer->value) ? implode(', ', $answer->value) : $answer->value }}</td>
            <td>{{ $answer->created_at->format('d/m/Y') }}</td>
            <td>
                @can('view', $answer)
                    <a href="{{ route('answers.show', $answer) }}" class="btn btn-sm btn-secondary">Ver</a>
                @endcan
                @can('delete', $answer)
                    <form action="{{ route('answers.destroy', $answer) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" x-text="confirmDelete ? 'Confirmar?' : 'Excluir'"></button>
                    </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
