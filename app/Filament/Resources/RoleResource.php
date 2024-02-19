<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Permission;
use App\Models\Role;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?string $navigationLabel = 'Access Roles';

    protected static ?int $navigationSort = 14;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Roles');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Roles');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Roles');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Roles');
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
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->columnSpan(12),
                            ]),
                    ])
                    ->columnSpan(12),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('permissions')
                            ->label('Permissions')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([Forms\Components\Fieldset::make('companies')
                                        ->label('Companies')
                                        ->schema([
                                            Forms\Components\CheckboxList::make('permissions')
                                                ->label('')
                                                ->bulkToggleable(true)
                                                ->required()
                                                ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Companies')->orderBy('id'))
                                                ->columnSpan(12),
                                        ])
                                        ->columnSpan(4),
                                        Forms\Components\Fieldset::make('clients')
                                            ->label('Clients')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Clients')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('staffs')
                                            ->label('Staff')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Staffs')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('quotes')
                                            ->label('Quotes')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Quotes')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('products')
                                            ->label('Products')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Products')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('simulations')
                                            ->label('Simulations')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Simulations')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('terms')
                                            ->label('Terms And Conditions')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Terms And Conditions')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('templates')
                                            ->label('Templates')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Templates')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('users')
                                            ->label('Users')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Users')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('sectors')
                                            ->label('Sectors')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Sectors')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('regions')
                                            ->label('Regions')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Regions')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('roles')
                                            ->label('Roles')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Roles')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('personnels')
                                            ->label('Personnels')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Personnels')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                        Forms\Components\Fieldset::make('permissions')
                                            ->label('Permissions')
                                            ->schema([
                                                Forms\Components\CheckboxList::make('permissions')
                                                    ->label('')
                                                    ->bulkToggleable(true)
                                                    ->required()
                                                    ->relationship('permissions','name', fn (Builder $query) => $query->where('name','LIKE','%Permissions')->orderBy('id'))
                                                    ->columnSpan(12),
                                            ])
                                            ->columnSpan(4),
                                    ]),
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
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
