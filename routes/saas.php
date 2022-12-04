<?php

use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SchoolController;
use Domain\Tenants\Models\Tenant;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
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

                Route::resource('classrooms', ClassRoomController::class);

                Route::resource('rooms', RoomController::class)->except(['create', 'edit']);

                Route::resource('students', TeamController::class);

                Route::get('/settings', [TeamController::class, 'show'])->name('settings');
            });
    });
};

if (Schema::connection('landlord')->hasTable('tenants')) {
    Tenant::pluck('domain')
        ->each(function($domain) use ($routing) {
            Route::domain($domain)
                ->middleware('tenant')
                ->group($routing);
        });
}
