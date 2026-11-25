<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Http\Requests\CandidatoRequest;
use Illuminate\Http\Request;

class CandidatoController extends Controller
{
    public function index(Request $request)
    {
        $filtros = $request->validate([
            'id' => 'nullable|integer|min:1',
            'nome' => 'nullable|string',
            'email' => 'nullable|string',
            'telefone' => 'nullable|string',
            'cpf' => 'nullable|string',
            'created_at' => 'nullable|date_format:Y-m-d',
            'updated_at' => 'nullable|date_format:Y-m-d',
        ]);

        $query = Candidato::query();

        if (isset($filtros['id'])) {
            $query->where('id', $filtros['id']);
        }

        foreach (['nome', 'email', 'telefone', 'cpf'] as $campo) {
            if (isset($filtros[$campo])) {
                $query->where(
                    $campo,
                    'like',
                    '%' . $filtros[$campo] . '%'
                );
            }
        }

        foreach (['created_at', 'updated_at'] as $campo) {
            if (isset($filtros[$campo])) {
                $query->whereDate($campo, $filtros[$campo]);
            }
        }

        $candidatos = $query->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('candidatos.index', compact('candidatos'));
    }

    public function create()
    {
        return view('candidatos.form', [
            'candidato' => new Candidato(),
        ]);
    }

    public function store(CandidatoRequest $request)
    {
        Candidato::create($request->validated());

        return redirect()->route('candidatos.index')
            ->with('success', 'Candidato cadastrado com sucesso!');
    }

    public function edit(Candidato $candidato)
    {
        return view('candidatos.form', compact('candidato'));
    }

    public function update(
        CandidatoRequest $request,
        Candidato $candidato
    ) {
        $candidato->update($request->validated());

        return redirect()->route('candidatos.index')
            ->with('success', 'Candidato atualizado com sucesso!');
    }

    public function destroy(Candidato $candidato)
    {
        $candidato->delete();

        return redirect()->route('candidatos.index')
            ->with('success', 'Candidato excluído com sucesso!');
    }
}
