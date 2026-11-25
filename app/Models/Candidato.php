<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Candidato extends Model
{
    use HasFactory;

    protected $table = 'candidatos';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
    ];

    public function vagas(): BelongsToMany
    {
        return $this->belongsToMany(
            Vaga::class,
            'inscricoes',
            'candidato_id',
            'vaga_id'
        )->withTimestamps();
    }
}
