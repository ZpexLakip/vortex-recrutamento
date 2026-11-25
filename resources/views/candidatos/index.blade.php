@extends('layouts.app')

@section('title', 'Candidatos')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Candidatos</h2>
        <p class="text-muted mb-0">
            Gerencie os candidatos cadastrados.
        </p>
    </div>

    <a href="{{ route('candidatos.create') }}"
        class="btn btn-primary">
        + Novo candidato
    </a>
</div>

<div class="card shadow-sm p-4 mb-4">

    <h5>Filtros</h5>

    <form method="GET" action="{{ route('candidatos.index') }}">

        <div class="row g-3">

            @foreach([
                'id' => 'ID',
                'nome' => 'Nome',
                'email' => 'E-mail',
                'telefone' => 'Telefone',
                'cpf' => 'CPF',
                'created_at' => 'Data de criação',
                'updated_at' => 'Última atualização'
            ] as $campo => $label)

                <div class="col-md-3">
                    <label class="form-label">
                        {{ $label }}
                    </label>

                    <input
                        type="{{ in_array($campo, ['created_at', 'updated_at']) ? 'date' : ($campo === 'id' ? 'number' : 'text') }}"
                        name="{{ $campo }}"
                        value="{{ request($campo) }}"
                        class="form-control"
                    >
                </div>

            @endforeach

            <div class="col-12">
                <button class="btn btn-primary">
                    Filtrar
                </button>

                <a href="{{ route('candidatos.index') }}"
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
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($candidatos as $candidato)

                    <tr>
                        <td>{{ $candidato->id }}</td>
                        <td>{{ $candidato->nome }}</td>
                        <td>{{ $candidato->email }}</td>
                        <td>{{ $candidato->telefone }}</td>
                        <td>{{ $candidato->cpf }}</td>

                        <td>
                            <div class="d-flex gap-2 flex-wrap">                            
                                <a href="{{ route('inscricoes.index', $candidato) }}"
                                    class="btn btn-sm btn-outline-success">
                                    Inscrições
                                </a>
                                <a href="{{ route('candidatos.edit', $candidato) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form method="POST"
                                    action="{{ route('candidatos.destroy', $candidato) }}"
                                    data-confirm="Deseja excluir este candidato?">

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
                        <td colspan="6"
                            class="text-center text-muted py-4">
                            Nenhum candidato encontrado.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <p class="text-muted">
        Total de registros: {{ $candidatos->total() }}
    </p>

    {{ $candidatos->links('pagination::bootstrap-5') }}

</div>

@endsection
