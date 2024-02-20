<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OccupationResource\Pages;
use App\Filament\Resources\OccupationResource\RelationManagers;
use App\Models\Occupation;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class OccupationResource extends Resource
{
    protected static ?string $model = Occupation::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?string $navigationLabel = 'Job Roles';

    protected static ?int $navigationSort = 15;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('discount'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOccupations::route('/'),
            'create' => Pages\CreateOccupation::route('/create'),
            'edit' => Pages\EditOccupation::route('/{record}/edit'),
        ];
    }
}
