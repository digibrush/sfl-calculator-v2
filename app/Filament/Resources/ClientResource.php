<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Clients';

    protected static ?string $slug = 'clients';

    protected static ?string $modelLabel = 'Client';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Contact Management';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Clients');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Clients');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Clients');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Clients');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'client');
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
                                            ->default('client'),
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('email')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('password')
                            ->label('Password')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('password')
                                            ->default('password')
                                            ->password()
                                            ->disabled(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                            ->same('confirm_password')
                                            ->dehydrated(fn ($state) => filled($state))
                                            ->columnSpan(6),
                                        Forms\Components\TextInput::make('confirm_password')
                                            ->default('password')
                                            ->label('Confirm Password')
                                            ->password()
                                            ->disabled(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                                            ->dehydrated(false)
                                            ->columnSpan(6),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('company')
                            ->label('Company')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Select::make('company_id')
                                            ->required()
                                            ->relationship('company', 'name')
                                            ->searchable()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpan(12),
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
//                                        Forms\Components\FileUpload::make('image')
//                                            ->directory('clients')
//                                            ->image()
//                                            ->columnSpan(12),
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
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->relationship('company', 'name')
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
            RelationManagers\QuotesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
