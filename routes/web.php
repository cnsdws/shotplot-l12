<?php

use App\Http\Controllers\PositionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RifleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirestringAdjustmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\BallisticProfileController;


    Route::middleware('auth')->group(function () {
    Route::get('/', [PositionsController::class, 'index']);
    Route::get('/match', [PositionsController::class, 'index']);

    Route::get('/create', [PositionsController::class, 'create']);
    Route::post('/create', [PositionsController::class, 'handleCreate']);

    Route::get('/edit/{match}', [PositionsController::class, 'edit']);
    Route::post('/edit', [PositionsController::class, 'handleEdit']);

    Route::get('/delete/{match}', [PositionsController::class, 'delete']);
    Route::post('/delete', [PositionsController::class, 'handleDelete']);
                                 
    Route::get('/match/{match}/summary', [AnalysisController::class, 'matchSummary']);

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
    Route::get('/displayfirestring/{id}/print', [PositionsController::class, 'printFirestring']);

    Route::get('/dashboard', [PositionsController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                                 
    Route::get('/rifles', [RifleController::class, 'index']);
    Route::get('/rifles/create', [RifleController::class, 'create']);
    Route::post('/rifles', [RifleController::class, 'store']);
    Route::get('/rifles/{rifle}', [RifleController::class, 'show']);
    Route::get('/rifles/{rifle}/edit', [RifleController::class, 'edit']);
    Route::post('/rifles/{rifle}', [RifleController::class, 'update']);
    Route::post('/rifles/{rifle}/delete', [RifleController::class, 'destroy']);
    Route::post('/rifles/{rifle}/configuration', [RifleController::class, 'updateConfiguration']);
                                 
    Route::get('/rifles/{rifle}/history', [RifleController::class, 'history']);
                                 
    Route::get('/firestrings/{firestring}/adjustments', [FirestringAdjustmentController::class, 'index']);
    Route::get('/firestrings/{firestring}/adjustments/create', [FirestringAdjustmentController::class, 'create']);
    Route::post('/firestrings/{firestring}/adjustments', [FirestringAdjustmentController::class, 'store']);
    Route::get('/firestring-adjustments/{adjustment}/edit', [FirestringAdjustmentController::class, 'edit']);
    Route::post('/firestring-adjustments/{adjustment}', [FirestringAdjustmentController::class, 'update']);
    Route::post('/firestring-adjustments/{adjustment}/delete', [FirestringAdjustmentController::class, 'destroy']);
                                 
    Route::get('/displayfirestring/{id}/print', [ReportController::class, 'printFirestring']);
                                 
    Route::get('/ballistics', [BallisticProfileController::class, 'index']);
    Route::get('/ballistics/create', [BallisticProfileController::class, 'create']);
    Route::post('/ballistics', [BallisticProfileController::class, 'store']);
    Route::get('/ballistics/{ballisticProfile}/edit', [BallisticProfileController::class, 'edit']);
    Route::post('/ballistics/{ballisticProfile}', [BallisticProfileController::class, 'update']);
    Route::post('/ballistics/{ballisticProfile}/delete', [BallisticProfileController::class, 'destroy']);
                                 
                                 
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

require __DIR__.'/auth.php';
