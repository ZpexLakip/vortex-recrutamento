<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\InscricaoController;

Route::redirect('/', '/vagas');

Route::patch('/vagas/{vaga}/toggle', [VagaController::class, 'toggle'])
    ->name('vagas.toggle');

Route::resource('vagas', VagaController::class)
    ->parameters(['vagas' => 'vaga'])
    ->except(['show']);

Route::resource('candidatos', CandidatoController::class)
    ->parameters(['candidatos' => 'candidato'])
    ->except(['show']);

Route::get('/candidatos/{candidato}/inscricoes',
    [InscricaoController::class, 'index'])
    ->name('inscricoes.index');

Route::post('/candidatos/{candidato}/inscricoes',
    [InscricaoController::class, 'store'])
    ->name('inscricoes.store');

Route::delete('/candidatos/{candidato}/inscricoes/{vaga}',
    [InscricaoController::class, 'destroy'])
    ->name('inscricoes.destroy');
