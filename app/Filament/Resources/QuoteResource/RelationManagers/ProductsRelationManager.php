<?php

namespace App\Filament\Resources\QuoteResource\RelationManagers;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\Product;
use App\Models\Solution;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    public function canCreate(): bool
    {
        return Auth::user()->can('Create Products');
    }

    public function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Products');
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
                                            ->default('quote'),
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
                    ])
                    ->columnSpan(12),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('hours')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('cost')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('solutions')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('projects')
                    ->toggleable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->successRedirectUrl(fn (Product $record): string => '/admin/products/'.$record->id.'/edit?'.((!is_null($record->quote)) ? 'type=quote&' : '').'activeRelationManager=0'),
                FilamentExportHeaderAction::make('export')
            ])
            ->actions([
                Tables\Actions\Action::make('up')
                    ->label("")
                    ->icon('heroicon-s-arrow-up')
                    ->action(fn (Product $record) => $record->moveOrderUp()),
                Tables\Actions\Action::make('down')
                    ->label("")
                    ->icon('heroicon-s-arrow-down')
                    ->action(fn (Product $record) => $record->moveOrderDown()),
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->url(fn (Product $record): string => url('/admin/products/'.$record->id.'/edit?type=quote&activeRelationManager=0'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
