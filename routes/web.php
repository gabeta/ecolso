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

Route::domain(config('app.domain'))
    ->group(function() {
        Route::get('/', function () {
            // dd('Redirection vers la page officiel');
        });
    });
