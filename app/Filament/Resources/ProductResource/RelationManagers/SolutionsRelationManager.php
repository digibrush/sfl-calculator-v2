<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Solution;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class SolutionsRelationManager extends RelationManager
{
    protected static string $relationship = 'solutions';

    protected static ?string $recordTitleAttribute = 'name';

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Solution $record): string =>
        ($record->product->quote != null)
            ?
            ($record->product->quote->type == "standard")
                ?
                url('/admin/solutions/'.$record->id.'/edit?type=quote&activeRelationManager=0')
                :
                (($record->product->quote->type == "template")
                    ?
                    url('/admin/solutions/'.$record->id.'/edit?type=template&activeRelationManager=0')
                    :
                    url('/admin/solutions/'.$record->id.'/edit?type=simulation&activeRelationManager=0'))
            :
            url('/admin/solutions/'.$record->id.'/edit?activeRelationManager=0');
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderBy('order');
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
                                            ->default(fn(RelationManager $livewire): string => ((!is_null($livewire->ownerRecord->quote)) ? 'quote' : 'standard')),
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
                        Forms\Components\Fieldset::make('summary')
                            ->label('Summary')
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
                    ->columnSpan(12),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('hours'),
                Tables\Columns\TextColumn::make('cost'),
                Tables\Columns\TextColumn::make('projects'),
                Tables\Columns\ToggleColumn::make('status'),
            ])
            ->reorderable('order')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->successRedirectUrl(fn (Solution $record): string => '/admin/products/'.$record->product->id.'/edit?'.((!is_null($record->product->quote)) ? 'type=quote&' : '').'activeRelationManager=0'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit-product-solution')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->quote != null) ? true : false)
                    ->url(fn (Solution $record): string => url('/admin/solutions/'.$record->id.'/edit?activeRelationManager=0'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\Action::make('edit-quote-solution')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->quote != null && $livewire->ownerRecord->quote->type == "standard") ? false : true)
                    ->url(fn (Solution $record): string => url('/admin/solutions/'.$record->id.'/edit?type=quote&activeRelationManager=0'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\Action::make('edit-simulator-solution')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->quote != null && $livewire->ownerRecord->quote->type == "simulation") ? false : true)
                    ->url(fn (Solution $record): string => url('/admin/solutions/'.$record->id.'/edit?type=simulation&activeRelationManager=0'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\Action::make('edit-template-solution')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->quote != null && $livewire->ownerRecord->quote->type == "template") ? false : true)
                    ->url(fn (Solution $record): string => url('/admin/solutions/'.$record->id.'/edit?type=template&activeRelationManager=0'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->successRedirectUrl(fn (Solution $record): string => '/admin/products/'.$record->product->id.'/edit?'.((!is_null($record->product->quote)) ? 'type=quote&' : '').'activeRelationManager=0'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
