@extends('layouts.app')

@section('title', 'Inscrições')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Inscrições</h2>

        <p class="text-muted">
            Candidato: {{ $candidato->nome }}
        </p>
    </div>

    <a href="{{ route('candidatos.index') }}"
        class="btn btn-outline-secondary">
        Voltar
    </a>
</div>

<div class="card shadow-sm p-4 mb-4">

    <h5 class="mb-3">Nova inscrição</h5>

    @if($vagas->isNotEmpty())

        <form method="POST"
            action="{{ route('inscricoes.store', $candidato) }}">

            @csrf

            <div class="mb-3">
                <label class="form-label">Selecione uma vaga</label>

                <select name="vaga_id" class="form-select" required>

                    <option value="">Selecione</option>

                    @foreach($vagas as $vaga)

                        <option value="{{ $vaga->id }}">
                            {{ $vaga->titulo }}
                            - {{ $vaga->tipo_contrato }}
                        </option>

                    @endforeach

                </select>
            </div>

            <button class="btn btn-primary">
                Realizar inscrição
            </button>

        </form>

    @else

        <p class="text-muted mb-0">
            Nenhuma nova vaga disponível para inscrição.
        </p>

    @endif

</div>

<div class="card shadow-sm p-4">

    <h5 class="mb-3">Vagas inscritas</h5>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>Vaga</th>
                    <th>Contrato</th>
                    <th>Status</th>
                    <th>Data da inscrição</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($inscricoes as $vaga)

                    <tr>
                        <td>{{ $vaga->titulo }}</td>

                        <td>{{ $vaga->tipo_contrato }}</td>

                        <td>
                            <span class="badge {{ $vaga->ativa
                                ? 'text-bg-success'
                                : 'text-bg-secondary' }}">

                                {{ $vaga->ativa ? 'Ativa' : 'Pausada' }}

                            </span>
                        </td>

                        <td>
                            {{ $vaga->pivot->created_at->format('d/m/Y') }}
                        </td>

                        <td>
                            <form method="POST"
                                action="{{ route('inscricoes.destroy', [$candidato, $vaga]) }}"
                                data-confirm="Deseja cancelar esta inscrição?">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    Cancelar inscrição
                                </button>

                            </form>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Nenhuma inscrição realizada.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
