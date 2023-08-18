<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Region;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 10;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Users');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Users');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Users');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\Select::make('discount')
                    ->multiple()
                    ->options(Region::all()->pluck('name', 'id'))
                    ->columnSpan('full')
                    ->required(),
//                Forms\Components\TextInput::make('discount')
//                    ->label('Discount')
//                    ->numeric()
//                    ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
//                        ->numeric()
//                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
//                        ->decimalSeparator('.') // Add a separator for decimal numbers.
//                        ->minValue(0) // Set the minimum value that the number can be.
//                        ->normalizeZeros() // Append or remove zeros at the end of the number.
//                        ->padFractionalZeros() // Pad zeros at the end of the number to always maintain the maximum number of decimal places.
//                        ->thousandsSeparator(',') // Add a separator for thousands.
//                    )
//                    ->columnSpan('full')
//                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->same('confirm_password')
                    ->dehydrated(fn($state) => filled($state)),
                Forms\Components\TextInput::make('confirm_password')
                    ->label('Confirm Password')
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
