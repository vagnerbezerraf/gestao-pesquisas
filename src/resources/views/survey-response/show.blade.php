@extends('layouts.app')

@section('title', $survey->title)

@section('content')
<div class="container survey-response">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">{{ $survey->title }}</h1>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <p class="lead mb-4">{{ $survey->description }}</p>

                    <form id="surveyForm" method="POST" action="{{ route('survey-response.store', $invite->token) }}">
                        @csrf
                        <div id="survey-progress" class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>

                        <!-- Páginas de perguntas -->
                        @foreach($chunkedQuestions as $pageIndex => $pageQuestions)
                            <div class="question-page" data-page="{{ $pageIndex + 1 }}" style="{{ $pageIndex > 0 ? 'display:none' : '' }}">
                                <h2 class="h5 mb-3">Página {{ $pageIndex + 1 }} de {{ $totalPages }}</h2>
                                
                                @foreach($pageQuestions as $question)
                                    <div class="question-container mb-4">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <strong>{{ $loop->parent->iteration }}.{{ $loop->iteration }}. {{ $question->text }}</strong>
                                                @if($question->group)
                                                    <span class="badge bg-secondary float-end">{{ $question->group->name }}</span>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                @error('answers.' . $question->id)
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                                @switch($question->type)
                                                    @case('text')
                                                        <textarea 
                                                            name="answers[{{ $question->id }}]" 
                                                            class="form-control @error('answers.' . $question->id) is-invalid @enderror" 
                                                            rows="3"
                                                            data-question-id="{{ $question->id }}"
                                                        >{{ old('answers.' . $question->id) }}</textarea>
                                                        @break
                                                    
                                                    @case('select')
                                                        <select 
                                                            name="answers[{{ $question->id }}]" 
                                                            class="form-select @error('answers.' . $question->id) is-invalid @enderror"
                                                            data-question-id="{{ $question->id }}"
                                                        >
                                                            <option value="">Selecione uma opção</option>
                                                            @foreach($question->options ?? [] as $option)
                                                                <option value="{{ trim($option) }}" {{ old('answers.' . $question->id) == trim($option) ? 'selected' : '' }}>
                                                                    {{ trim($option) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @break
                                                    
                                                    @case('radio')
                                                        <div class="d-flex flex-column gap-2">
                                                            @foreach($question->options ?? [] as $option)
                                                                <div class="form-check">
                                                                    <input 
                                                                        class="form-check-input @error('answers.' . $question->id) is-invalid @enderror" 
                                                                        type="radio" 
                                                                        name="answers[{{ $question->id }}]" 
                                                                        id="q{{ $question->id }}_{{ $loop->index }}" 
                                                                        value="{{ trim($option) }}"
                                                                        data-question-id="{{ $question->id }}"
                                                                        {{ old('answers.' . $question->id) == trim($option) ? 'checked' : '' }}
                                                                    >
                                                                    <label class="form-check-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                                                        {{ trim($option) }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @break
                                                    
                                                    @case('checkbox')
                                                        <div class="d-flex flex-column gap-2">
                                                            @php $oldValues = is_array(old('answers.' . $question->id)) ? old('answers.' . $question->id) : []; @endphp
                                                            @foreach($question->options ?? [] as $option)
                                                                <div class="form-check">
                                                                    <input 
                                                                        class="form-check-input @error('answers.' . $question->id) is-invalid @enderror" 
                                                                        type="checkbox" 
                                                                        name="answers[{{ $question->id }}][]" 
                                                                        id="q{{ $question->id }}_{{ $loop->index }}" 
                                                                        value="{{ trim($option) }}"
                                                                        data-question-id="{{ $question->id }}"
                                                                        {{ in_array(trim($option), $oldValues) ? 'checked' : '' }}
                                                                    >
                                                                    <label class="form-check-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                                                        {{ trim($option) }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @break
                                                    
                                                    @default
                                                        <input 
                                                            type="text" 
                                                            name="answers[{{ $question->id }}]" 
                                                            class="form-control @error('answers.' . $question->id) is-invalid @enderror"
                                                            value="{{ old('answers.' . $question->id) }}"
                                                            data-question-id="{{ $question->id }}"
                                                        >
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-between mt-4">
                                    @if($pageIndex > 0)
                                        <button type="button" class="btn btn-outline-secondary prev-page">Anterior</button>
                                    @else
                                        <div></div>
                                    @endif

                                    @if($pageIndex < $totalPages - 1)
                                        <button type="button" class="btn btn-primary next-page">Próxima</button>
                                    @else
                                        <button type="submit" class="btn btn-success">Enviar Respostas</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .survey-response .card-header {
        border-radius: 0.25rem 0.25rem 0 0;
    }
    
    .survey-response .question-container {
        transition: all 0.3s ease;
    }
    
    .survey-response .question-container:hover {
        transform: translateY(-2px);
    }
    
    .survey-response .progress {
        height: 20px;
        border-radius: 10px;
    }
    
    .survey-response .badge {
        font-weight: normal;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('surveyForm');
        const pages = document.querySelectorAll('.question-page');
        const progressBar = document.querySelector('.progress-bar');
        const totalPages = {{ $totalPages }};
        let currentPage = 1;
        let answers = {};
        
        // Carregar respostas salvas do localStorage
        try {
            const savedAnswers = localStorage.getItem('survey_{{ $survey->id }}_{{ $invite->token }}');
            if (savedAnswers) {
                answers = JSON.parse(savedAnswers);
                
                // Preencher os campos com as respostas salvas
                Object.entries(answers).forEach(([questionId, value]) => {
                    const inputs = document.querySelectorAll(`[data-question-id="${questionId}"]`);
                    
                    inputs.forEach(input => {
                        if (input.type === 'checkbox') {
                            if (Array.isArray(value) && value.includes(input.value)) {
                                input.checked = true;
                            }
                        } else if (input.type === 'radio') {
                            if (input.value === value) {
                                input.checked = true;
                            }
                        } else if (input.tagName === 'SELECT') {
                            input.value = value;
                        } else {
                            input.value = value;
                        }
                    });
                });
            }
        } catch (e) {
            console.error('Erro ao carregar respostas salvas:', e);
        }
        
        // Atualizar a barra de progresso
        function updateProgress() {
            const progress = (currentPage / totalPages) * 100;
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
            progressBar.textContent = `${Math.round(progress)}%`;
        }
        
        // Salvar respostas no localStorage
        function saveAnswers() {
            // Coletar todas as respostas do formulário
            const formData = new FormData(form);
            
            for (const [key, value] of formData.entries()) {
                if (key.startsWith('answers[') && key.endsWith(']')) {
                    // Extrair o ID da pergunta da chave
                    const matches = key.match(/answers\[(\d+)\]/);
                    if (matches && matches[1]) {
                        const questionId = matches[1];
                        
                        // Verificar se já existe uma resposta para esta pergunta
                        if (key.endsWith('[]')) {
                            // Para checkboxes (múltiplas respostas)
                            if (!answers[questionId]) {
                                answers[questionId] = [];
                            }
                            
                            if (!answers[questionId].includes(value)) {
                                answers[questionId].push(value);
                            }
                        } else {
                            // Para outros tipos de input
                            answers[questionId] = value;
                        }
                    }
                }
            }
            
            // Salvar no localStorage
            localStorage.setItem('survey_{{ $survey->id }}_{{ $invite->token }}', JSON.stringify(answers));
        }
        
        // Validar a página atual
        function validateCurrentPage() {
            const currentPageElement = document.querySelector(`.question-page[data-page="${currentPage}"]`);
            const requiredInputs = currentPageElement.querySelectorAll('input[required], select[required], textarea[required]');
            
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            return isValid;
        }
        
        // Navegar para a próxima página
        document.querySelectorAll('.next-page').forEach(button => {
            button.addEventListener('click', function() {
                saveAnswers();
                
                if (currentPage < totalPages) {
                    document.querySelector(`.question-page[data-page="${currentPage}"]`).style.display = 'none';
                    currentPage++;
                    document.querySelector(`.question-page[data-page="${currentPage}"]`).style.display = 'block';
                    updateProgress();
                    
                    // Scroll para o topo
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });
        
        // Navegar para a página anterior
        document.querySelectorAll('.prev-page').forEach(button => {
            button.addEventListener('click', function() {
                saveAnswers();
                
                if (currentPage > 1) {
                    document.querySelector(`.question-page[data-page="${currentPage}"]`).style.display = 'none';
                    currentPage--;
                    document.querySelector(`.question-page[data-page="${currentPage}"]`).style.display = 'block';
                    updateProgress();
                    
                    // Scroll para o topo
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });
        
        // Ao enviar o formulário
        form.addEventListener('submit', function(e) {
            saveAnswers();
            
            // Limpar o localStorage após o envio bem-sucedido
            localStorage.removeItem('survey_{{ $survey->id }}_{{ $invite->token }}');
        });
        
        // Salvar respostas quando o usuário sair da página
        window.addEventListener('beforeunload', function() {
            saveAnswers();
        });
        
        // Inicializar a barra de progresso
        updateProgress();
    });
</script>
@endpush
