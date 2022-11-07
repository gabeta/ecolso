<?php

namespace App\Filament\Resources\SchoolYearResource\Pages;

use App\Filament\Resources\SchoolYearResource;
use App\Models\Landlord\SchoolYear;
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
