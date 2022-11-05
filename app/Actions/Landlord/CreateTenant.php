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
        return DB::transaction(function () use ($data) {
            $tenant = Tenant::create([
                'name' => $data->name,
                'database' => $data->database,
                'domain' => $data->domain,
                'description' => $data->description
            ]);

            Artisan::call("tenants:artisan 'migrate --database=tenant'");

            app(SwitchTenantDatabaseTask::class)->makeCurrent($tenant);

            event(new Registered(User::create([
                'name' => $data->user->name,
                'email' => $data->user->email,
                'password' => bcrypt($data->user->password)
            ])));

            return $tenant;
        });
    }
}
