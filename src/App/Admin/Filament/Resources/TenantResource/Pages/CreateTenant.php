<?php

namespace Ecolso\Admin\Filament\Resources\TenantResource\Pages;

use Domain\Permissions\Enums\RoleEnum;
use Domain\Tenants\Actions\CreateNewTenantDomain;
use Domain\Tenants\DataTransferObjects\CreateTenantData;
use Domain\Users\DataTransferObjects\CreateUserData;
use Ecolso\Admin\Filament\Resources\TenantResource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateTenant extends CreateRecord
{
    use HasWizard;

    protected static string $resource = TenantResource::class;

    protected function getSteps(): array
    {
        return [
           Wizard\Step::make('Projet')
                ->description("Informations sur l'IEP")
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('domain')
                        ->suffix('.'.config('app.domain'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('database')
                        ->prefix('ecolso_')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('description')
                        ->maxLength(65535),
                ]),
            Wizard\Step::make('Utilisateur')
                ->description("L'administration du projet")
                ->schema([
                    TextInput::make('user_name')
                        ->label("Nom et prénom(s)")
                        ->required()
                        ->maxLength(191),
                    TextInput::make('email')
                        ->label("Adresse mail")
                        ->email()
                        ->required()
                        //->unique('users')
                        ->maxLength(191),
                ]),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $createTenantData = new CreateTenantData([
            'name' => $data['name'],
            'database' => config('database.tenant_prefix').$data['database'],
            'domain' => $data['domain'].'.'.config('app.domain'),
            'description' => $data['description'] ?? null,
            'user' => new CreateUserData([
                'name' => $data['user_name'],
                'email' => $data['email'],
                'password' => Str::random(8),
                'roles' => collect([RoleEnum::ADMIN]),
                'is_super_admin' => true
            ]),
        ]);

        return (app(CreateNewTenantDomain::class))($createTenantData);
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'IEP crée avec succès 😊.';
    }
}
