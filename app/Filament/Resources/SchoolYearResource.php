<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolYearResource\Pages;
use App\Filament\Resources\SchoolYearResource\RelationManagers;
use App\Models\Landlord\SchoolYear;
use App\Rules\DateExist;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolYearResource extends Resource
{
    protected static ?string $model = SchoolYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_current'),
                DatePicker::make('begin_at')
                    ->required(),
                DatePicker::make('end_at')
                    ->required()
                    ->after('begin_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('begin_at'),
                Tables\Columns\TextColumn::make('end_at'),
                Tables\Columns\IconColumn::make('is_current')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchoolYears::route('/'),
            'create' => Pages\CreateSchoolYear::route('/create'),
            'edit' => Pages\EditSchoolYear::route('/{record}/edit'),
        ];
    }
}