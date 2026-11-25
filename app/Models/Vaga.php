<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vaga extends Model
{
    use HasFactory;

    protected $table = 'vagas';

    protected $fillable = [
        'titulo',
        'descricao',
        'tipo_contrato',
        'salario',
        'ativa',
    ];

    protected $casts = [
        'ativa' => 'boolean',
        'salario' => 'decimal:2',
    ];

    public function candidatos(): BelongsToMany
    {
        return $this->belongsToMany(
            Candidato::class,
            'inscricoes',
            'vaga_id',
            'candidato_id'
        )->withTimestamps();
    }
}

