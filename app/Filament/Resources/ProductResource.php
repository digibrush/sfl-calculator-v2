<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Products');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Products');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Products');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Products');
    }

    public static function canReorder(): bool
    {
        return Auth::user()->can('Reorder Products');
    }

    public static function getEloquentQuery(): Builder
    {
        if (request()->type == "quote") {
            return parent::getEloquentQuery()->where('type', 'quote')->orderBy('order');
        }
        if (request()->type == "simulation") {
            return parent::getEloquentQuery()->where('type', 'simulation')->orderBy('order');
        }
        if (request()->type == "template") {
            return parent::getEloquentQuery()->where('type', 'template')->orderBy('order');
        }
        return parent::getEloquentQuery()->where('type', 'standard')->orderBy('order');
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
                                            ->default('standard'),
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
                        Forms\Components\Fieldset::make('media')
                            ->label('Media')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->directory('products')
                                            ->image()
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('video')
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(5),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('summary')
                            ->label('Summary')
                            ->schema([
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
                                Forms\Components\Fieldset::make('costs')
                                    ->label('Costs')
                                    ->schema([
                                        Forms\Components\Grid::make(12)
                                            ->schema([
                                                Forms\Components\TextInput::make('cost')
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
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('hours'),
                Tables\Columns\TextColumn::make('cost'),
                Tables\Columns\TextColumn::make('solutions'),
                Tables\Columns\TextColumn::make('projects'),
                Tables\Columns\ToggleColumn::make('status'),
            ])
            ->reorderable('order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (Product $record): string => url('/admin/products/'.$record->id.'/edit?activeRelationManager=0')),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SolutionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
