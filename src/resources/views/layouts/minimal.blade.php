<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-light bg-light border-bottom mb-4">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
          <img src="{{ asset('images/logo_3eb.png') }}" alt="Logo" style="max-height:40px;">
          <span class="fw-bold">{{ config('app.name') }}</span>
        </a>
      </div>
    </nav>
    <main class="container my-4">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
