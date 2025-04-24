<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/surveys') }}">
      <img src="{{ asset('images/logo_3eb.png') }}" alt="Logo" style="max-height:50px;">
      Gestão Pesquisas
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
        @else
          @can('viewAny', App\Models\Survey::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/surveys') }}">Surveys</a></li>
          @endcan
          @can('viewAny', App\Models\Question::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/questions') }}">Questions</a></li>
          @endcan
          @can('viewAny', App\Models\Answer::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/answers') }}">Answers</a></li>
          @endcan
          @can('viewAny', App\Models\Group::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/groups') }}">Groups</a></li>
          @endcan
          @can('viewAny', App\Models\QuestionGroup::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/question-groups') }}">Question Groups</a></li>
          @endcan
          @can('viewAny', App\Models\Invite::class)
          <li class="nav-item"><a class="nav-link" href="{{ url('/invites') }}">Invites</a></li>
          @endcan
          <li class="nav-item">
            <form method="POST" action="{{ url('/logout') }}">
              @csrf
              <button class="btn btn-link nav-link" type="submit">Logout</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
