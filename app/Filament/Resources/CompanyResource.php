<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\CompanyResource\RelationManagers;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    protected static ?string $navigationGroup = 'Contact Management';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Companies');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Companies');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Companies');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Companies');
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
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('address')
                            ->label('Address')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('address_1')
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('address_2')
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('city')
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('state')
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('country')
                                            ->maxLength(255)
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
                                        Forms\Components\Select::make('sector')
                                            ->relationship('companySector', 'name')
                                            ->columnSpan(12),
                                        Forms\Components\Select::make('industry_id')
                                            ->relationship('industry', 'name')
                                            ->columnSpan(12),
                                        Forms\Components\Select::make('scale')
                                            ->options([
                                                'Small' => 'Small',
                                                'Medium' => 'Medium',
                                                'Large' => 'Large',
                                            ])
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(8),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('media')
                            ->label('Media')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->directory('companies')
                                            ->image()
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(4),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('country'),
                Tables\Columns\TextColumn::make('companySector.name')
                    ->label('Sector'),
            ])
            ->filters([
//                Tables\Filters\SelectFilter::make('city')
//                    ->options(fn (Company $resource): array => $resource->pluck('city', 'city')->toArray()),
//                Tables\Filters\SelectFilter::make('country')
//                    ->options(fn (Company $resource): array => $resource->pluck('country', 'country')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color("warning"),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ClientsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
