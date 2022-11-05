<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Actions\Landlord\CreateTenant as LandlordCreateTenant;
use App\Data\TenantFormData;
use App\Data\UserFormData;
use App\Filament\Resources\TenantResource;
use App\Models\Landlord\Tenant;
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
        $tenantFormData = new TenantFormData([
            'name' => $data['name'],
            'database' => 'ecolso_'.$data['database'],
            'domain' => $data['domain'].'.'.config('app.domain'),
            'description' => $data['description'] ?? null,
            'user' => new UserFormData([
                'name' => $data['user_name'],
                'email' => $data['email'],
                'password' => Str::random(8)
            ]),
        ]);

        return app(\App\Actions\Landlord\CreateTenant::class)->handle($tenantFormData);
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'IEP crée avec succès 😊.';
    }
}
