<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OrganizerHistoricController;
use App\Http\Controllers\CanceledEventController;
use App\Http\Controllers\EventVersionController;
use App\Http\Controllers\UserInterfaceController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function(){   
    Route::get('/', [UserInterfaceController::class, 'index'])->name('Accueil');
    Route::get('/Événements', [UserInterfaceController::class, 'events'])->name('Événements');
    Route::get('/événements/{event}', [UserInterfaceController::class, 'show'])->name('événement');
});

Route::get('/event-admin', function () {
    return view('auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

Route::middleware('auth')->group(function () {
    \App\Models\Event::updatePassedEvents();
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Parametres
    Route::prefix('parametres')->group(function(){
        // Categories
        Route::prefix('categories')->group(function(){
            Route::get('/', [CategorieController::class, 'index'])->name('categories');
            Route::post('/', [CategorieController::class, 'store'])->name('categories.store');
            Route::put('/{categorie}', [CategorieController::class, 'update'])->name('categories.update');
            Route::delete('/{categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');
        });
        // Regions
        Route::prefix('regions')->group(function(){
            Route::get('/', [RegionController::class, 'index'])->name('regions');
            Route::post('/', [RegionController::class, 'store'])->name('regions.store');
            Route::put('/{region}', [RegionController::class, 'update'])->name('regions.update');
            Route::delete('/{region}', [RegionController::class, 'destroy'])->name('regions.destroy');
        });
        // Cities
        Route::prefix('cities')->group(function(){
            Route::get('/', [CityController::class, 'index'])->name('cities');
            Route::post('/', [CityController::class, 'store'])->name('cities.store');
            Route::put('/{city}', [CityController::class, 'update'])->name('cities.update');
            Route::delete('/{city}', [CityController::class, 'destroy'])->name('cities.destroy');
        });
        // Applications
        Route::prefix('applications')->group(function(){
            Route::get('/', [ApplicationController::class, 'index'])->name('applications');
            Route::put('/{id}', [ApplicationController::class, 'update'])->name('applications.update');
        });
    });
    
    // Organizers
    Route::prefix('organizers')->group(function(){
        Route::get('/', [OrganizerController::class, 'index'])->name('organizers');
        Route::get('/create', [OrganizerController::class, 'create'])->name('organizers.create');
        Route::post('/', [OrganizerController::class, 'store'])->name('organizers.store');
        Route::put('/{organizer}/status', [OrganizerController::class, 'updateStatus'])->name('organizers.updateStatus');
        Route::put('/{organizer}', [OrganizerController::class, 'update'])->name('organizers.update');
    });

    // Events
    Route::prefix('events')->group(function(){
        Route::get('/', [EventController::class, 'index'])->name('events');
        Route::get('/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/', [EventController::class, 'store'])->name('events.store');
        Route::get('/{event}', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('events.update');
        Route::put('/{event}/status', [EventController::class, 'updateStatus'])->name('events.updateStatus');
        Route::post('/{event}/request-update', [EventController::class, 'requestUpdate'])->name('events.requestUpdate');
        Route::get('/{event}/versions', [EventVersionController::class, 'index'])->name('events.versions');
    });
    Route::get('/events-passed', [EventController::class, 'eventsPassed'])->name('events.passed');
    Route::get('/events-canceled', [EventController::class, 'eventsCanceled'])->name('events.canceled');

    // 
});

require __DIR__.'/auth.php';
