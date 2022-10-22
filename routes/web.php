<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


// dd('*.'.config('app.domain'));

Route::domain('{tenant}.'.config('app.domain'))
    ->middleware('tenant')
    ->group(function() {
        Route::get('/', function () {
            return Inertia::render('Welcome', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'laravelVersion' => Application::VERSION,
                'phpVersion' => PHP_VERSION,
            ]);
        });

        Route::middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
        ])->group(function () {
            Route::get('/dashboard', function () {
                return Inertia::render('Dashboard');
            })->name('dashboard');
        });
    });

Route::domain(config('app.domain'))
    ->group(function() {
        Route::get('/', function () {
            dd('Redirection vers la page officiel');
        });
    });
