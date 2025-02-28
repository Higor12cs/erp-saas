<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Auth/Login'))->name('login');
    Route::post('/login', LoginController::class)->name('login.attempt');
    Route::get('/registrar', fn () => Inertia::render('Auth/Register'))->name('register');
    Route::post('/registrar', RegisterController::class)->name('register.attempt');
});

Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/home', fn () => Inertia::render('Home/Index'))->name('home.index');
    Route::get('/dashboard', fn () => Inertia::render('Dashboard/Index'))->name('dashboard.index');

    Route::get('/clientes', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/clientes/criar', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/clientes', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/clientes/{customer:sequential_id}/editar', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/clientes/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/clientes/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/fornecedores', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/fornecedores/criar', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/fornecedores', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/fornecedores/{supplier}/editar', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/fornecedores/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/fornecedores/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/criar', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/produtos/criar', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produtos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::redirect('/', '/home');
