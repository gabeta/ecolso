<?php

use Domain\Tenants\Actions\CreateTenantDatabase;
use Domain\Tenants\Models\Tenant;
use Domain\Users\Models\User;
use Ecolso\Admin\Filament\Resources\TenantResource\Pages\CreateTenant;
use Illuminate\Support\Facades\Mail;

use function Pest\Faker\faker;
use function Pest\Livewire\livewire;

it('can create new tenant', function() {
    CreateTenantDatabase::fake();
    // Mail::fake();

    livewire(CreateTenant::class)
        ->fillForm([
            'name' => ($name = faker()->name),
            'email' => ($email = faker()->email),
            'domain' => ($domain = 'tafire'),
            'database' => ($database = 'tenant_test'),
            'user_name' => ($userName = faker()->name),
            'email' => ($email = faker()->email),
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Tenant::class, [
        'name' => $name,
        'domain' => $domain.'.'.config('app.domain'),
        'database' => config('database.tenant_prefix').$database,
    ]);

    $this->assertDatabaseHas(User::class, [
        'name' => $userName,
        'email' => $email,
    ]);
});
