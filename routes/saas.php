<?php

use App\Http\Controllers\SchoolController;
use App\Models\Landlord\Tenant;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Jetstream\Http\Controllers\Inertia\TeamController;

/*
|--------------------------------------------------------------------------
|SaasWeb Routes
|--------------------------------------------------------------------------
|
| Here is where you can register saas routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web, tenant" middleware group. Now create something great!
|
*/

$routing = function() {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::resource('schools', SchoolController::class)->except('destroy');

        Route::prefix('/{team}/year/{year?}')
            ->middleware('saas')
            ->name('app.')
            ->group(function () {
                Route::get('/', function () {
                    return Inertia::render('App/Dashboard');
                })->name('dashboard');

                Route::prefix('settings/')
                    ->name('settings.')
                    ->group(function() {
                        Route::get('/general', [TeamController::class, 'show'])->name('general');
                    });
            });
    });
};

Tenant::pluck('domain')
    ->each(function($domain) use ($routing) {
        Route::domain($domain)
            ->middleware('tenant')
            ->group($routing);
    });
