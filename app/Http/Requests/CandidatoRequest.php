<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('candidato')?->id;

        return [
            'nome' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('candidatos', 'email')->ignore($id),
            ],

            'telefone' => [
                'required',
                'string',
                'regex:/^[0-9()+\s-]{8,20}$/',
            ],

            'cpf' => [
                'required',
                'digits:11',
                Rule::unique('candidatos', 'cpf')->ignore($id), //Editar sem Duplicar
            ],
        ];
    }
}
