<?php

namespace App\Filament\Resources\QuoteResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class EmailsRelationManager extends RelationManager
{
    protected static string $relationship = 'emails';

    protected static ?string $recordTitleAttribute = 'created_at';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reciepient')
                    ->default(fn(RelationManager $livewire): string => $livewire->ownerRecord->client->email)
                    ->disabled()
                    ->columnSpan('full'),
                Forms\Components\Select::make('document_id')
                    ->options(fn(RelationManager $livewire): Collection => $livewire->ownerRecord->documents->pluck('label', 'id'))
                    ->required()
                    ->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('document.label'),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        'pending' => 'Pending',
                        'sent' => 'Sent',
                    ])
                    ->colors([
                        'primary',
                        'warning' => 'pending',
                        'success' => 'sent',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
