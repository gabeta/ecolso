<?php

namespace Ecolso\Admin\Filament\Resources\SchoolYearResource\Pages;

use Domain\SchoolYears\Models\SchoolYear;
use Ecolso\Admin\Filament\Resources\SchoolYearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolYear extends CreateRecord
{
    protected static string $resource = SchoolYearResource::class;

    protected function afterCreate(): void
    {
        if ($this->record->is_current) {
            SchoolYear::where('is_current', 1)
                ->where('id', '!=', $this->record->id)
                ->update([
                    'is_current' => 0
                ]);
        }
    }
}