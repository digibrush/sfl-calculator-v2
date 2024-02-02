<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Page;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 5;

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
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\Toggle::make('status')
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('hours')
                            ->label('Hours')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('hours')
                                            ->default(0)
                                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditRecord)
                                            ->numeric()
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('configuration')
                            ->label('Configuration')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Select::make('price_category')
                                            ->options([
                                                'standard' => 'Standard',
                                                'branch' => 'Per Branch',
                                                'country' => 'Per Country',
                                            ])
                                            ->columnSpan(6),
                                        Forms\Components\Select::make('personnel_id')
                                            ->label('Assigned Personnel')
                                            ->relationship('personnel', 'title')
                                            ->required()
                                            ->columnSpan(6),
                                    ])
                                    ->columnSpan(12),
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(7),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('summary')
                            ->label('Summary')
                            ->schema([
                                Forms\Components\Fieldset::make('total_hours')
                                    ->label('Total Hours')
                                    ->schema([
                                        Forms\Components\Grid::make(12)
                                            ->schema([
                                                Forms\Components\TextInput::make('total_hours')
                                                    ->default(0)
                                                    ->disabled()
                                                    ->numeric()
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(12)
                                    ])
                                    ->columnSpan(12),
                                Forms\Components\Fieldset::make('total_cost')
                                    ->label('Total Cost')
                                    ->schema([
                                        Forms\Components\Grid::make(12)
                                            ->schema([
                                                Forms\Components\TextInput::make('total_cost')
                                                    ->default(0)
                                                    ->disabled()
                                                    ->numeric()
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(12)
                                    ])
                                    ->columnSpan(12),
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(5),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('total_hours')
                    ->label('Hours'),
                Tables\Columns\TextColumn::make('total_cost')
                    ->label('Cost'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
