<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Vortex Recrutamento')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background-color: #f4f6fa;
        }

        .navbar {
            background-color: #172033;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .table th {
            white-space: nowrap;
        }

        .btn {
            border-radius: 7px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            Vortex Recrutamento
        </a>

        <div class="navbar-nav flex-row gap-3">
            <a class="nav-link" href="{{ route('vagas.index') }}">
                Vagas
            </a>
        </div>
    </div>
</nav>

<main class="container pb-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Verifique os dados informados:</strong>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</main>

<script>
    document.querySelectorAll('[data-confirm]').forEach(form => {
        form.addEventListener('submit', event => {
            if (!confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });
</script>

</body>
</html>
