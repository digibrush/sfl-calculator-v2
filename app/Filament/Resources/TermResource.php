<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermResource\Pages;
use App\Filament\Resources\TermResource\RelationManagers;
use App\Models\Term;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TermResource extends Resource
{
    protected static ?string $model = Term::class;

    protected static ?string $navigationLabel = 'Terms and Conditions';

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Terms And Conditions');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Terms And Conditions');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Terms And Conditions');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Terms And Conditions');
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
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(12),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('terms')
                            ->label('Terms')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Repeater::make('content')
                                            ->schema([
                                                Forms\Components\TextInput::make('condition')
                                                    ->required()
                                                    ->label('Condition')
                                                    ->columnSpan(12),
                                            ])
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
            'index' => Pages\ListTerms::route('/'),
            'create' => Pages\CreateTerm::route('/create'),
            'edit' => Pages\EditTerm::route('/{record}/edit'),
        ];
    }
}
