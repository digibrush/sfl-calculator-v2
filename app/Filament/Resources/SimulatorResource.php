<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SimulatorResource\Pages;
use App\Filament\Resources\SimulatorResource\RelationManagers;
use App\Models\Quote;
use App\Models\Rate;
use App\Models\Region;
use App\Models\Simulator;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SimulatorResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $label = 'Simulation';

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationGroup = 'Quote Management';

    protected static ?string $navigationLabel = 'Simulations';

    protected static ?string $slug = 'simulations';

    protected static ?int $navigationSort = 7;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Simulations');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Simulations');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Simulations');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Simulations');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'simulation');
    }

    public static function form(Form $form): Form
    {
        $max = 0;
        $regions = (new Region)->newCollection();
        if (Auth::user()->discount != null) {
            foreach (Auth::user()->discount as $discount) {
                $region = Region::findOrFail($discount);
                $regions->add($region);
            }
            $max = $regions->toQuery()->orderBy('discount', 'DESC')->first()->discount;
        }
        return $form
            ->schema([
                Forms\Components\Hidden::make('type')
                    ->default('simulation'),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('muliplier')
                            ->label('Multiplier')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('countries')
                                            ->default(1)
                                            ->numeric()
                                            ->required()
                                            ->minValue(1)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('branches')
                                            ->default(1)
                                            ->numeric()
                                            ->required()
                                            ->minValue(1)
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('discount')
                            ->label('Discount')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('discount')
                                            ->default(0)
                                            ->numeric()
                                            ->maxValue($max)
                                            ->columnSpan(12),
                                        Forms\Components\Textarea::make('discount_note')
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(fn(Page $livewire): int => ($livewire instanceof CreateRecord) ? 12 : 5),
                Forms\Components\Card::make()
                    ->hidden(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->schema([
                        Forms\Components\Fieldset::make('summary')
                            ->label('Summary')
                            ->schema([
                                Forms\Components\Fieldset::make('selection')
                                    ->label('Selection')
                                    ->schema([
                                        Forms\Components\Grid::make(12)
                                            ->schema([
                                                Forms\Components\TextInput::make('solutions')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(12),
                                                Forms\Components\TextInput::make('projects')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(12),
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
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(12)
                                    ])
                                    ->columnSpan(12),
                                Forms\Components\Fieldset::make('cost')
                                    ->label('Cost')
                                    ->schema([
                                        Forms\Components\Grid::make(12)
                                            ->schema([
                                                Forms\Components\TextInput::make('cost')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(12),
                                                Forms\Components\TextInput::make('discount_amount')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(12),
                                                Forms\Components\TextInput::make('total_cost')
                                                    ->default(0)
                                                    ->numeric()
                                                    ->disabled()
                                                    ->columnSpan(12),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created Date')
                    ->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('cost'),
                Tables\Columns\TextColumn::make('discount_amount'),
                Tables\Columns\TextColumn::make('total_cost'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicate')
                    ->hidden(!Auth::user()->can('Duplicate Simulations'))
                    ->color('warning')
                    ->url(fn (Quote $record): string => url('/quote/'.$record->id.'/duplicate?type=simulation'))
                    ->icon('heroicon-s-document-duplicate'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
            RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSimulators::route('/'),
            'create' => Pages\CreateSimulator::route('/create'),
            'edit' => Pages\EditSimulator::route('/{record}/edit'),
            'calender' => Pages\Configurator::route('/{record}/configurator'),
        ];
    }
}
