<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VagaController;

Route::redirect('/', '/vagas');

Route::patch('/vagas/{vaga}/toggle', [VagaController::class, 'toggle'])
    ->name('vagas.toggle');

Route::resource('vagas', VagaController::class)
    ->parameters(['vagas' => 'vaga'])
    ->except(['show']);
