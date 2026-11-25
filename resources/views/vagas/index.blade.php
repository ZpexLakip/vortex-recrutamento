@extends('layouts.app')

@section('title', 'Gerenciamento de vagas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Vagas</h2>
        <p class="text-muted mb-0">
            Gerencie as oportunidades de emprego.
        </p>
    </div>

    <a href="{{ route('vagas.create') }}" class="btn btn-primary">
        + Nova vaga
    </a>
</div>

<div class="card shadow-sm p-4 mb-4">
    <h5 class="mb-3">Filtros</h5>

    <form method="GET" action="{{ route('vagas.index') }}">
        <div class="row g-3">

            @foreach([
                'id' => 'ID',
                'titulo' => 'Título',
                'descricao' => 'Descrição',
                'salario' => 'Salário'
            ] as $campo => $label)

                <div class="col-md-3">
                    <label class="form-label">{{ $label }}</label>

                    <input
                        type="{{ in_array($campo, ['id', 'salario']) ? 'number' : 'text' }}"
                        step="{{ $campo === 'salario' ? '0.01' : '1' }}"
                        name="{{ $campo }}"
                        value="{{ request($campo) }}"
                        class="form-control"
                    >
                </div>

            @endforeach

            <div class="col-md-3">
                <label class="form-label">Contrato</label>

                <select name="tipo_contrato" class="form-select">
                    <option value="">Todos</option>

                    @foreach(['CLT', 'PJ', 'Freelancer'] as $tipo)
                        <option value="{{ $tipo }}"
                            @selected(request('tipo_contrato') === $tipo)>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>

                <select name="ativa" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" @selected(request('ativa') === '1')>
                        Ativa
                    </option>
                    <option value="0" @selected(request('ativa') === '0')>
                        Pausada
                    </option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Data de criação</label>
                <input type="date" name="created_at"
                    value="{{ request('created_at') }}"
                    class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Última atualização</label>
                <input type="date" name="updated_at"
                    value="{{ request('updated_at') }}"
                    class="form-control">
            </div>

            <div class="col-12">
                <button class="btn btn-primary">Filtrar</button>

                <a href="{{ route('vagas.index') }}"
                    class="btn btn-outline-secondary">
                    Limpar
                </a>
            </div>

        </div>
    </form>
</div>

<div class="card shadow-sm p-3">

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Contrato</th>
                    <th>Salário</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($vagas as $vaga)

                    <tr>
                        <td>{{ $vaga->id }}</td>

                        <td class="fw-semibold">
                            {{ $vaga->titulo }}
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($vaga->descricao, 70) }}
                        </td>

                        <td>{{ $vaga->tipo_contrato }}</td>

                        <td>
                            {{ $vaga->salario !== null
                                ? 'R$ ' . number_format($vaga->salario, 2, ',', '.')
                                : 'A combinar' }}
                        </td>

                        <td>
                            <span class="badge {{ $vaga->ativa
                                ? 'text-bg-success'
                                : 'text-bg-secondary' }}">

                                {{ $vaga->ativa ? 'Ativa' : 'Pausada' }}

                            </span>
                        </td>

                        <td>
                            <div class="d-flex gap-2 flex-wrap">

                                <a href="{{ route('vagas.edit', $vaga) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form method="POST"
                                    action="{{ route('vagas.toggle', $vaga) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-sm btn-outline-warning">
                                        {{ $vaga->ativa ? 'Pausar' : 'Reativar' }}
                                    </button>

                                </form>

                                <form method="POST"
                                    action="{{ route('vagas.destroy', $vaga) }}"
                                    data-confirm="Deseja realmente excluir esta vaga?">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
                                        Excluir
                                    </button>

                                </form>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Nenhuma vaga encontrada.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <p class="text-muted">
        Total de registros: {{ $vagas->total() }}
    </p>

    {{ $vagas->links('pagination::bootstrap-5') }}

</div>

@endsection
