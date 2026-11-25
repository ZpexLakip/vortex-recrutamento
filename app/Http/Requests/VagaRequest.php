<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VagaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'tipo_contrato' => 'required|in:CLT,PJ,Freelancer',
            'salario' => 'nullable|numeric|min:0|max:99999999.99|decimal:0,2',
            'ativa' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'Informe o título da vaga.',
            'descricao.required' => 'Informe a descrição da vaga.',
            'tipo_contrato.required' => 'Selecione o tipo de contrato.',
            'tipo_contrato.in' => 'Tipo de contrato inválido.',
            'salario.numeric' => 'O salário deve ser numérico.',
            'salario.min' => 'O salário não pode ser negativo.',
            'salario.max' => 'O salário informado é muito alto.',
            'salario.decimal' => 'Informe até duas casas decimais.',
            'ativa.required' => 'Informe o status da vaga.',
            'ativa.boolean' => 'Status inválido.',
        ];
    }
}
