<?php

use App\Http\Controllers\PositionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RifleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [PositionsController::class, 'index']);
    Route::get('/match', [PositionsController::class, 'index']);

    Route::get('/create', [PositionsController::class, 'create']);
    Route::post('/create', [PositionsController::class, 'handleCreate']);

    Route::get('/edit/{match}', [PositionsController::class, 'edit']);
    Route::post('/edit', [PositionsController::class, 'handleEdit']);

    Route::get('/delete/{match}', [PositionsController::class, 'delete']);
    Route::post('/delete', [PositionsController::class, 'handleDelete']);

    Route::get('/myaccount', [PositionsController::class, 'myaccount']);
    Route::post('/myaccount', [PositionsController::class, 'handleMyAccount']);
    Route::post('/updatepassword', [PositionsController::class, 'updatePassword']);

    Route::get('/createfirestring/{id}', [PositionsController::class, 'createFirestring']);
    Route::post('/createfirestring', [PositionsController::class, 'handleCreateFirestring']);

    Route::get('/editfirestring/{id}', [PositionsController::class, 'editFirestring']);
    Route::post('/editfirestring/{id}', [PositionsController::class, 'handleEditFirestring']);

    Route::get('/deletefirestring/{id}', [PositionsController::class, 'deleteFirestring']);
    Route::post('/deletefirestring/{id}', [PositionsController::class, 'handleDeleteFirestring']);

    Route::get('/indexfirestring/{id}', [PositionsController::class, 'indexFirestring']);
    Route::get('/firestring/{id}', [PositionsController::class, 'indexFirestring']);
    Route::get('/displayfirestring/{id}', [PositionsController::class, 'displayFirestring']);

    Route::get('/dashboard', [PositionsController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                                 
    Route::get('/rifles', [RifleController::class, 'index']);
    Route::get('/rifles/create', [RifleController::class, 'create']);
    Route::post('/rifles', [RifleController::class, 'store']);
    Route::get('/rifles/{rifle}/edit', [RifleController::class, 'edit']);
    Route::post('/rifles/{rifle}', [RifleController::class, 'update']);
    Route::post('/rifles/{rifle}/delete', [RifleController::class, 'destroy']);
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

require __DIR__.'/auth.php';
