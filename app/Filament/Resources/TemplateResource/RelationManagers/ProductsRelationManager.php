<?php

namespace App\Filament\Resources\TemplateResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return Auth::user()->can('Access Products');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
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
                //
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->url(fn (Product $record): string => url('/admin/products/'.$record->id.'/edit?type=template'))
                    ->icon('heroicon-s-pencil')
                    ->hidden(!Auth::user()->can('Edit Products')),
                Tables\Actions\DeleteAction::make()
                    ->hidden(!Auth::user()->can('Delete Products')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
