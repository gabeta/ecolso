<?php

namespace App\Actions\Landlord;

use App\Data\TenantFormData;
use App\Models\Landlord\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask;

class CreateTenant
{
    public function handle(TenantFormData $data): Tenant
    {
        $tenant = Tenant::create([
            'name' => $data->name,
            'database' => $data->database,
            'domain' => $data->domain,
            'description' => $data->description
        ]);

        DB::unprepared("CREATE DATABASE IF NOT EXISTS $data->database;");

        Artisan::call("tenants:artisan --tenant={$tenant->id} -- \"migrate --database=tenant\"");

        app(SwitchTenantDatabaseTask::class)->makeCurrent($tenant);

        event(new Registered(User::create([
            'name' => $data->user->name,
            'email' => $data->user->email,
            'password' => bcrypt($data->user->password)
        ])));

        return $tenant;
    }
}
