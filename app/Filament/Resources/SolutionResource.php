<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolutionResource\Pages;
use App\Filament\Resources\SolutionResource\RelationManagers;
use App\Models\Solution;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    protected static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        if (request()->type == "quote") {
            return parent::getEloquentQuery()->where('type', 'quote');
        }
        if (request()->type == "simulation") {
            return parent::getEloquentQuery()->where('type', 'simulation');
        }
        if (request()->type == "template") {
            return parent::getEloquentQuery()->where('type', 'template');
        }
        return parent::getEloquentQuery()->where('type', 'standard');
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
                                        Forms\Components\Hidden::make('type')
                                            ->default('standard'),
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\Textarea::make('overview')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\Toggle::make('status')
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('media')
                            ->label('Media')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->directory('solutions')
                                            ->image()
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(5),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('summary')
                            ->label('Summary')
                            ->schema([
                                Forms\Components\Fieldset::make('hours')
                                    ->label('Hours')
                                    ->schema([
                                        Forms\Components\Grid::make(12)
                                            ->schema([
                                                Forms\Components\TextInput::make('online_hours')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(6),
                                                Forms\Components\TextInput::make('offline_hours')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(6),
                                            ])
                                            ->columnSpan(12)
                                    ])
                                    ->columnSpan(12),
                                Forms\Components\Fieldset::make('cost')
                                    ->label('Costs')
                                    ->schema([
                                        Forms\Components\Grid::make(12)
                                            ->schema([
                                                Forms\Components\TextInput::make('online_cost')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(6),
                                                Forms\Components\TextInput::make('offline_cost')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(6),
                                            ])
                                            ->columnSpan(12)
                                    ])
                                    ->columnSpan(12),
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(7),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('online_hours'),
                Tables\Columns\TextColumn::make('offline_hours'),
                Tables\Columns\TextColumn::make('online_cost'),
                Tables\Columns\TextColumn::make('offline_cost'),
                Tables\Columns\TextColumn::make('projects'),
                Tables\Columns\ToggleColumn::make('status'),
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
            RelationManagers\ProjectsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolutions::route('/'),
            'create' => Pages\CreateSolution::route('/create'),
            'edit' => Pages\EditSolution::route('/{record}/edit'),
        ];
    }
}
