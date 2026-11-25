@extends('layouts.app')

@section('title', $candidato->exists ? 'Editar candidato' : 'Novo candidato')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card shadow-sm p-4">

            <h2 class="fw-bold mb-4">
                {{ $candidato->exists
                    ? 'Editar candidato'
                    : 'Cadastrar candidato' }}
            </h2>

            <form method="POST"
                action="{{ $candidato->exists
                    ? route('candidatos.update', $candidato)
                    : route('candidatos.store') }}">

                @csrf

                @if($candidato->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Nome *</label>

                    <input type="text"
                        name="nome"
                        value="{{ old('nome', $candidato->nome) }}"
                        class="form-control"
                        maxlength="255"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">E-mail *</label>

                    <input type="email"
                        name="email"
                        value="{{ old('email', $candidato->email) }}"
                        class="form-control"
                        maxlength="255"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefone *</label>

                    <input type="tel"
                        name="telefone"
                        value="{{ old('telefone', $candidato->telefone) }}"
                        class="form-control"
                        maxlength="20"
                        required>
                </div>

                <div class="mb-4">
                    <label class="form-label">CPF *</label>

                    <input type="text"
                        name="cpf"
                        value="{{ old('cpf', $candidato->cpf) }}"
                        class="form-control"
                        maxlength="11"
                        pattern="[0-9]{11}"
                        inputmode="numeric"
                        placeholder="Somente números"
                        required>
                </div>

                <button class="btn btn-primary">
                    Salvar candidato
                </button>

                <a href="{{ route('candidatos.index') }}"
                    class="btn btn-outline-secondary">
                    Cancelar
                </a>

            </form>

        </div>

    </div>
</div>

@endsection
