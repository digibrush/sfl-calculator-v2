<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RateResource\Pages;
use App\Filament\Resources\RateResource\RelationManagers;
use App\Models\Rate;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RateResource extends Resource
{
    protected static ?string $model = Rate::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 9;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Rates');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Rates');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Rates');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Rates');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('standard')
                            ->label('Standard Rates')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('standard_online_rate')
                                            ->label('Online Rate')
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
                                            ->columnSpan(6),
                                        Forms\Components\TextInput::make('standard_offline_rate')
                                            ->label('Offline Rate')
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
                                            ->columnSpan(6),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('premium')
                            ->label('Premium Rates')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('premium_online_rate')
                                            ->label('Online Rate')
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
                                            ->columnSpan(6),
                                        Forms\Components\TextInput::make('premium_offline_rate')
                                            ->label('Offline Rate')
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
                                            ->columnSpan(6),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(12),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('standard_online_rate')
                    ->label('Standard Online Rate'),
                Tables\Columns\TextColumn::make('standard_offline_rate')
                    ->label('Standard Offline Rate'),
                Tables\Columns\TextColumn::make('premium_online_rate')
                    ->label('Premium Online Rate'),
                Tables\Columns\TextColumn::make('premium_offline_rate')
                    ->label('Premium Offline Rate'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRates::route('/'),
            'edit' => Pages\EditRate::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            RateResource\Widgets\RatesOverview::class,
        ];
    }
}
