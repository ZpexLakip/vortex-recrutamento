
@extends('layouts.app')

@section('title', $vaga->exists ? 'Editar vaga' : 'Nova vaga')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card shadow-sm p-4">

            <h2 class="fw-bold mb-4">
                {{ $vaga->exists ? 'Editar vaga' : 'Cadastrar vaga' }}
            </h2>

            <form method="POST"
                action="{{ $vaga->exists
                    ? route('vagas.update', $vaga)
                    : route('vagas.store') }}">

                @csrf

                @if($vaga->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Título da vaga *</label>

                    <input
                        type="text"
                        name="titulo"
                        value="{{ old('titulo', $vaga->titulo) }}"
                        class="form-control"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição *</label>

                    <textarea
                        name="descricao"
                        class="form-control"
                        rows="5"
                        required
                    >{{ old('descricao', $vaga->descricao) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de contrato *</label>

                    <select name="tipo_contrato" class="form-select" required>

                        <option value="">Selecione</option>

                        @foreach(['CLT', 'PJ', 'Freelancer'] as $tipo)
                            <option value="{{ $tipo }}"
                                @selected(old('tipo_contrato', $vaga->tipo_contrato) === $tipo)>
                                {{ $tipo }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Salário (R$)</label>

                    <input
                        type="number"
                        name="salario"
                        value="{{ old('salario', $vaga->salario) }}"
                        class="form-control"
                        min="0"
                        max="99999999.99"
                        step="0.01"
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">Status *</label>

                    <select name="ativa" class="form-select" required>

                        <option value="1"
                            @selected((int) old('ativa', $vaga->ativa) === 1)>
                            Ativa
                        </option>

                        <option value="0"
                            @selected((int) old('ativa', $vaga->ativa) === 0)>
                            Pausada
                        </option>

                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Salvar vaga
                </button>

                <a href="{{ route('vagas.index') }}"
                    class="btn btn-outline-secondary">
                    Cancelar
                </a>

            </form>

        </div>

    </div>
</div>

@endsection
