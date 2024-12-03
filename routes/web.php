<?php

use App\Http\Controllers\ProfileController;
use App\Models\Produto;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { # o certo era criar um controller, na volta eu arrumo
    $produtos = Produto::all();
    return view('home', compact('produtos'));
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
