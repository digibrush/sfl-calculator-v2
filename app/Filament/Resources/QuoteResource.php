<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteResource\Pages;
use App\Filament\Resources\QuoteResource\RelationManagers;
use App\Models\Quote;
use App\Models\Region;
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

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Quote Management';

    protected static ?int $navigationSort = 6;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Quotes');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Quotes');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Quotes');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Quotes');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'standard');
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
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('basics')
                            ->label('Basics')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Select::make('client_id')
                                            ->label('Client')
                                            ->relationship('client', 'name', fn (Builder $query) => $query->where('type','client'))
                                            ->searchable()
                                            ->required()
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('reference')
                                            ->required()
                                            ->hidden(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\Toggle::make('converted')
                                            ->hidden(fn(Page $livewire): bool => $livewire instanceof CreateRecord),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
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
                            ->hidden(fn(Page $livewire): bool => !Auth::user()->discount_allowed)
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
                Tables\Columns\TextColumn::make('reference')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('assignee.name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('client.company.name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('cost')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_cost')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('converted')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-check' => true,
                        'heroicon-o-x' => false,
                    ])
                    ->colors([
                        'secondary',
                        'success' => true,
                        'danger' => false,
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicate')
                    ->hidden(!Auth::user()->can('Duplicate Quotes'))
                    ->color('warning')
                    ->url(fn (Quote $record): string => url('/quote/'.$record->id.'/duplicate'))
                    ->icon('heroicon-s-document-duplicate'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('template')
                        ->label('Convert To Template')
                        ->hidden(!(Auth::user()->can('Access Templates') && Auth::user()->can('Edit Templates') && Auth::user()->can('Create Templates')))
                        ->color('warning')
                        ->url(fn (Quote $record): string => url('/quote/'.$record->id.'/template'))
                        ->icon('heroicon-s-template'),
                    Tables\Actions\Action::make('simulation')
                        ->label('Create A Simulation')
                        ->hidden(!(Auth::user()->can('Access Simulations') && Auth::user()->can('Edit Simulations') && Auth::user()->can('Create Simulations')))
                        ->color('warning')
                        ->url(fn (Quote $record): string => url('/quote/'.$record->id.'/create-simulation'))
                        ->icon('heroicon-s-cube-transparent'),
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
            RelationManagers\EmailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
            'calender' => Pages\Calender::route('/calender'),
        ];
    }
}
