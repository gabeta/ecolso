<?php

use App\Http\Controllers\SchoolController;
use App\Models\Landlord\Tenant;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    });
};

Tenant::pluck('domain')
    ->each(function($domain) use ($routing) {
        Route::domain($domain)
            ->middleware('tenant')
            ->group($routing);
    });
