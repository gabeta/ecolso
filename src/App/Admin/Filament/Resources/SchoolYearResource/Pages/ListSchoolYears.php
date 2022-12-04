<?php

namespace Ecolso\Admin\Filament\Resources\SchoolYearResource\Pages;

use Ecolso\Admin\Filament\Resources\SchoolYearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchoolYears extends ListRecords
{
    protected static string $resource = SchoolYearResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
