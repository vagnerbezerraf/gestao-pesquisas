@extends('layouts.app')

@section('title','Configurar Pesquisa')

@section('content')
<form method="POST" action="{{ route('surveys.configure.save') }}" id="configForm">
    @csrf
    <div class="mb-3">
        <label for="surveySelect" class="form-label">Selecione a Pesquisa</label>
        <select id="surveySelect" name="survey_id" class="form-select">
            <option value="">-- Selecione --</option>
            @foreach($surveys as $s)
                <option value="{{ $s->id }}" {{ old('survey_id') == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
            @endforeach
        </select>
        @error('survey_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="questionFilter" class="form-control" placeholder="Filtrar por texto">
        </div>
        <div class="col-md-4">
            <select id="groupFilter" class="form-select">
                <option value="">Todos os grupos</option>
                @foreach($groups as $g)
                    <option value="{{ $g->name }}">{{ $g->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <label class="form-label">Disponíveis</label>
            <select id="availableQuestions" multiple size="10" class="form-select"></select>
        </div>
        <div class="col-md-2 d-flex flex-column justify-content-center align-items-center">
            <button type="button" id="btnAdd" class="btn btn-secondary mb-2">&gt;</button>
            <button type="button" id="btnAddAll" class="btn btn-secondary mb-2">&gt;&gt;</button>
            <button type="button" id="btnRemove" class="btn btn-secondary">&lt;</button>
            <button type="button" id="btnRemoveAll" class="btn btn-secondary">&lt;&lt;</button>
        </div>
        <div class="col-md-5">
            <label class="form-label">Selecionadas</label>
            <select id="selectedQuestions" name="questions[]" multiple size="10" class="form-select"></select>
        </div>
    </div>
    @error('questions')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Salvar Associação</button>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const surveyQuestions = @json($surveys->mapWithKeys(fn($s)=>[$s->id=>$s->questions->pluck('id')]));
    const allQuestions = @json($groups->flatMap(fn($g)=>$g->questions->map(fn($q)=>['id'=>$q->id,'text'=>$q->text,'group'=>$g->name])));

    function fillLists(surveyId) {
        const selIds = surveyQuestions[surveyId] || [];
        $('#selectedQuestions').empty();
        selIds.forEach(id => {
            const q = allQuestions.find(item => item.id === id);
            if (q) {
                $('#selectedQuestions').append(`<option value="${q.id}" data-group="${q.group}">${q.text} (${q.group})</option>`);
            }
        });
        updateAvailable();
    }

    function updateAvailable() {
        const text = $('#questionFilter').val().toLowerCase();
        const group = $('#groupFilter').val();
        const selectedIds = $('#selectedQuestions option').map((i, opt) => +opt.value).get();
        const filtered = allQuestions
            .filter(q => !selectedIds.includes(q.id))
            .filter(q => (!text || q.text.toLowerCase().includes(text)) && (!group || q.group === group));
        const $avail = $('#availableQuestions').empty();
        filtered.forEach(q => {
            $avail.append(`<option value="${q.id}" data-group="${q.group}">${q.text} (${q.group})</option>`);
        });
    }

    $(function() {
        $('#surveySelect').on('change', function() {
            fillLists($(this).val());
        });
        $('#questionFilter, #groupFilter').on('input change', updateAvailable);
        $('#btnAdd').on('click', function() {
            $('#availableQuestions option:selected').each(function() {
                $('#selectedQuestions').append(this);
            });
            updateAvailable();
        });
        $('#btnRemove').on('click', function() {
            $('#selectedQuestions option:selected').each(function() {
                $('#availableQuestions').append(this);
            });
            updateAvailable();
        });
        $('#btnAddAll').on('click', function() {
            $('#availableQuestions option').appendTo('#selectedQuestions');
            updateAvailable();
        });
        $('#btnRemoveAll').on('click', function() {
            $('#selectedQuestions option').appendTo('#availableQuestions');
            updateAvailable();
        });
        // Select all options in the selectedQuestions list before form submission
        $('#configForm').on('submit', function() {
            $('#selectedQuestions option').prop('selected', true);
            
            // Validate that at least one question is selected
            if ($('#selectedQuestions option').length === 0) {
                alert('Selecione pelo menos uma pergunta.');
                return false;
            }
            
            // Validate that a survey is selected
            if (!$('#surveySelect').val()) {
                alert('Selecione uma pesquisa.');
                return false;
            }
            
            return true;
        });
        
        // initial load: populate available list for empty selection
        $('#surveySelect').trigger('change');
    });
</script>
@endpush
