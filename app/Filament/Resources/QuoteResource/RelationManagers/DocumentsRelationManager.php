<?php

namespace App\Filament\Resources\QuoteResource\RelationManagers;

use App\Models\Document;
use App\Models\Quote;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $recordTitleAttribute = 'label';

    protected function getTablePollingInterval(): ?string
    {
        return '10s';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->columnSpan('full')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        'pending' => 'Pending',
                        'generated' => 'Generated',
                    ])
                    ->colors([
                        'primary',
                        'warning' => 'pending',
                        'success' => 'generated',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\ButtonAction::make('generate')
                    ->label('Generate PDF')
                    ->url(fn (RelationManager $livewire): string => url('/quote/'.$livewire->ownerRecord->id.'/generate-pdf'))
                    ->icon('heroicon-s-refresh'),
            ])
            ->actions([
                Tables\Actions\Action::make('financial')
                    ->label('Financial')
                    ->visible(fn (Document $record): bool => ($record->financial == null) ? false : true)
                    ->url(fn (Document $record): string => $record->financial)
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-cloud-download'),
                Tables\Actions\Action::make('technical')
                    ->label('Technical')
                    ->visible(fn (Document $record): bool => ($record->technical == null) ? false : true)
                    ->url(fn (Document $record): string => $record->technical)
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-cloud-download'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
