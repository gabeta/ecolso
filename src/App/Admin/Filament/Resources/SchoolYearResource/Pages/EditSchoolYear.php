<?php

namespace Ecolso\Admin\Filament\Resources\SchoolYearResource\Pages;

use Domain\SchoolYears\Models\SchoolYear;
use Ecolso\Admin\Filament\Resources\SchoolYearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolYear extends EditRecord
{
    protected static string $resource = SchoolYearResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
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
