<?php

namespace Ecolso\Admin\Filament\Resources\TenantResource\Pages;

use Ecolso\Admin\Filament\Resources\TenantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
