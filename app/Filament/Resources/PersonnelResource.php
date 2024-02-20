<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonnelResource\Pages;
use App\Filament\Resources\PersonnelResource\RelationManagers;
use App\Models\Personnel;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PersonnelResource extends Resource
{
    protected static ?string $model = Personnel::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 13;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Personnels');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Personnels');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Personnels');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Personnels');
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
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('rate')
                                            ->numeric()
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
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('rate'),
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
            'index' => Pages\ListPersonnels::route('/'),
            'create' => Pages\CreatePersonnel::route('/create'),
            'edit' => Pages\EditPersonnel::route('/{record}/edit'),
        ];
    }
}
