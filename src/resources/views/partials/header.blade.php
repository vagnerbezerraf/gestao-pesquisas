<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/surveys') }}" title="{{ config('app.name') }}">
      <img src="{{ asset('images/logo_3eb.png') }}" alt="Logo" style="max-height:50px;">
      {{ config('app.name') }}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Entrar</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Registrar</a></li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Painel</a></li>
          @can('viewAny', App\Models\Survey::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/surveys') }}">Pesquisas</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('surveys.configure') }}">Configurar Pesquisa</a></li>
          @endcan
          @can('viewAny', App\Models\Question::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/questions') }}">Perguntas</a></li>
          @endcan
          @can('viewAny', App\Models\QuestionCategory::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/question-categories') }}">Categorias de Perguntas</a></li>
          @endcan
          @can('viewAny', App\Models\Answer::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/answers') }}">Respostas</a></li>
          @endcan
          @can('viewAny', App\Models\Group::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/groups') }}">Grupos</a></li>
          @endcan
          @can('viewAny', App\Models\Invite::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/invites') }}">Convites</a></li>
          @endcan
          <li class="nav-item">
            <form method="POST" action="{{ url('/logout') }}">
              @csrf
              <button class="btn btn-link nav-link" type="submit">Sair</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
