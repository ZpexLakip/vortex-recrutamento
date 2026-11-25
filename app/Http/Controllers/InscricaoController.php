<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InscricaoController extends Controller
{
    public function index(Candidato $candidato)
    {
        $inscricoes = $candidato->vagas()->get();

        $vagas = Vaga::where('ativa', true)
            ->whereNotIn('id', $inscricoes->pluck('id'))
            ->orderBy('titulo')
            ->get();

        return view('inscricoes.index', compact(
            'candidato',
            'vagas',
            'inscricoes'
        ));
    }

    public function store(Request $request, Candidato $candidato)
    {
        $dados = $request->validate([
            'vaga_id' => 'required|integer|exists:vagas,id',
        ]);

        DB::transaction(function () use ($dados, $candidato) {
            $vaga = Vaga::lockForUpdate()
                ->findOrFail($dados['vaga_id']);

            if (!$vaga->ativa) {
                throw ValidationException::withMessages([
                    'vaga_id' => 'Esta vaga está pausada.',
                ]);
            }

            if ($candidato->vagas()->where('vagas.id', $vaga->id)->exists()) {
                throw ValidationException::withMessages([
                    'vaga_id' => 'O candidato já está inscrito nesta vaga.',
                ]);
            }

            $candidato->vagas()->attach($vaga->id);
        });

        return redirect()
            ->route('inscricoes.index', $candidato)
            ->with('success', 'Inscrição realizada com sucesso!');
    }

    public function destroy(Candidato $candidato, Vaga $vaga)
    {
        $candidato->vagas()->detach($vaga->id);

        return redirect()
            ->route('inscricoes.index', $candidato)
            ->with('success', 'Inscrição cancelada com sucesso!');
    }
}
