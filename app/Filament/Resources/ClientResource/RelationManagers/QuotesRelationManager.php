<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\Quote;
use App\Models\Solution;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuotesRelationManager extends RelationManager
{
    protected static string $relationship = 'clientQuotes';

    protected static ?string $title = 'Quotes';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                                            ->columnSpan(12),
                                        Forms\Components\Textarea::make('discount_note')
                                            ->columnSpan(12),
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
                Tables\Columns\TextColumn::make('reference'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('online_cost'),
                Tables\Columns\TextColumn::make('offline_cost'),
                Tables\Columns\TextColumn::make('discount_amount'),
                Tables\Columns\TextColumn::make('total_cost'),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->url(fn (Quote $record): string => url('/admin/quotes/'.$record->id.'/edit'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
