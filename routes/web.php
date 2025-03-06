<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/login', [HomeController::class, 'login'])->name('login');

Route::prefix('/event/{event}')->group(function () {

    // Mettre un participant comme présent pour un évenement
    Route::get('/presence', [EventController::class, 'presence'])->name('event.presence');
    Route::post('/presence', [EventController::class, 'savePresence']);

    // Créer un nouveau participant pour un évenement
    Route::get('/participant/nouveau', [ParticipantController::class, 'create'])->name('participant.create');
    Route::post('/participant/nouveau', [ParticipantController::class, 'store']);

    // Ajouter un participant existant pour un évenement
    Route::get('/participant/ajouter', [EventController::class, 'addParticipant'])->name('event.add-participant');
    Route::post('/participant/ajouter', [EventController::class, 'saveParticipant']);

});

