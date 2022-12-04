<?php

namespace Ecolso\Admin\Filament\Resources\TenantResource\Pages;

use Ecolso\Admin\Filament\Resources\TenantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
