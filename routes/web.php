<?php

use App\Http\Controllers\HistoricsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Autenticação
Route::get('/login', [UserController::class, 'index_login'])->name('view.login');
Route::post('/login', [UserController::class, 'login'])->name('user.login');

Route::get('/register', [UserController::class, 'index_register'])->name('view.register');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

// user
Route::resources(['/user' => UserController::class]);

//historics
Route::resources(['/historics' => HistoricsController::class]);

// equação
Route::get('/equacao', function () {
    return view('user.equacao');
})->name('equacao');

Route::post('/equacao', [UserController::class, 'equacao'])->name('equacao.envia');

// financeiro
Route::get('/financeiro', function () {
    return view('user.financeiro');
})->name('financeiro');

Route::post('/financeiro', [UserController::class, 'financeiro'])->name('financeiro.envia');

// pagseguro
Route::get('/pagseguro', [UserController::class, 'pagseguro'])->name('pagseguro');
Route::post('/plano', [UserController::class, 'plano'])->name('plano');
Route::post('/boleto', [UserController::class, 'boleto'])->name('boleto');

// cotações
Route::get('/cotacao', [UserController::class, 'cotacao'])->name('cotacao');
Route::post('/pesquisa_cotacao', [UserController::class, 'pesquisa_cotacao'])->name('pesquisa_cotacao');
