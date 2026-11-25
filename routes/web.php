<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\CandidatoController;

Route::redirect('/', '/vagas');

Route::patch('/vagas/{vaga}/toggle', [VagaController::class, 'toggle'])
    ->name('vagas.toggle');

Route::resource('vagas', VagaController::class)
    ->parameters(['vagas' => 'vaga'])
    ->except(['show']);

Route::resource('candidatos', CandidatoController::class)
    ->parameters(['candidatos' => 'candidato'])
    ->except(['show']);

