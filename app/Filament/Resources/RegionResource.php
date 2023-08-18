<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionResource\Pages;
use App\Filament\Resources\RegionResource\RelationManagers;
use App\Models\Region;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 12;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Regions');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Regions');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Regions');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Regions');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('basics')
                            ->label('Basics')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('discount')
                                            ->numeric()
                                            ->mask(
                                                fn (Forms\Components\TextInput\Mask $mask) => $mask
                                                    ->numeric()
                                                    ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                                    ->decimalSeparator('.') // Add a separator for decimal numbers.
                                                    ->minValue(1) // Set the minimum value that the number can be.
                                                    ->normalizeZeros() // Append or remove zeros at the end of the number.
                                                    ->padFractionalZeros() // Pad zeros at the end of the number to always maintain the maximum number of decimal places.
                                                    ->thousandsSeparator(',') // Add a separator for thousands.
                                            )
                                            ->required()
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(12),
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
            'index' => Pages\ListRegions::route('/'),
            'create' => Pages\CreateRegion::route('/create'),
            'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
