<?php

namespace App\Http\Controllers;

use App\Http\Requests\VagaRequest;
use App\Models\Vaga;
use Illuminate\Http\Request;

class VagaController extends Controller
{
    public function index(Request $request)
    {
        $filtros = $request->validate([
            'id' => 'nullable|integer|min:1',
            'titulo' => 'nullable|string',
            'descricao' => 'nullable|string',
            'tipo_contrato' => 'nullable|in:CLT,PJ,Freelancer',
            'salario' => 'nullable|numeric|min:0',
            'ativa' => 'nullable|boolean',
            'created_at' => 'nullable|date_format:Y-m-d',
            'updated_at' => 'nullable|date_format:Y-m-d',
        ]);

        $query = Vaga::query();

        foreach (['titulo', 'descricao'] as $campo) {
            if (isset($filtros[$campo])) {
                $query->where(
                    $campo,
                    'like',
                    '%' . $filtros[$campo] . '%'
                );
            }
        }

        foreach (['id', 'tipo_contrato', 'salario', 'ativa'] as $campo) {
            if (isset($filtros[$campo])) {
                $query->where($campo, $filtros[$campo]);
            }
        }

        foreach (['created_at', 'updated_at'] as $campo) {
            if (isset($filtros[$campo])) {
                $query->whereDate($campo, $filtros[$campo]);
            }
        }

        $vagas = $query->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('vagas.index', compact('vagas'));
    }

    public function create()
    {
        return view('vagas.form', [
            'vaga' => new Vaga(['ativa' => true]),
        ]);
    }

    public function store(VagaRequest $request)
    {
        Vaga::create($request->validated());

        return redirect()->route('vagas.index')
            ->with('success', 'Vaga cadastrada com sucesso!');
    }

    public function edit(Vaga $vaga)
    {
        return view('vagas.form', compact('vaga'));
    }

    public function update(VagaRequest $request, Vaga $vaga)
    {
        $vaga->update($request->validated());

        return redirect()->route('vagas.index')
            ->with('success', 'Vaga atualizada com sucesso!');
    }

    public function destroy(Vaga $vaga)
    {
        $vaga->delete();

        return redirect()->route('vagas.index')
            ->with('success', 'Vaga excluída com sucesso!');
    }

    public function toggle(Vaga $vaga)
    {
        $vaga->update([
            'ativa' => !$vaga->ativa,
        ]);

        return redirect()->route('vagas.index')
            ->with('success', 'Status da vaga atualizado!');
    }
}
