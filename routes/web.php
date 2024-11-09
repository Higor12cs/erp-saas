<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::post('/login', LoginController::class)->middleware('guest')->name('login.attempt');
Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('/inicio', 'app.home.index')->name('home.index');
    Route::view('/dashboard', 'app.dashboard.index')->name('dashboard.index');

    Route::view('/clientes', 'app.customers.index')->name('customers.index');
    Route::view('/clientes/novo', 'app.customers.create')->name('customers.create');
    Route::view('/clientes/{customer}/editar', 'app.customers.edit')->name('customers.edit');

    Route::view('/fornecedores', 'app.suppliers.index')->name('suppliers.index');
    Route::view('/fornecedores/novo', 'app.suppliers.create')->name('suppliers.create');
    Route::view('/fornecedores/{supplier}/editar', 'app.suppliers.edit')->name('suppliers.edit');
});
