<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Models\Region;
use App\Models\Staff;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Staffs';

    protected static ?string $slug = 'staffs';

    protected static ?string $modelLabel = 'Staff';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Contact Management';

    protected static ?int $navigationSort = 3;

    public static function canViewAny(): bool
    {
        return Auth::user()->can('Access Staffs');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Staffs');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('Edit Staffs');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Staffs');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'staff');
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
                                            ->default('staff'),
                                        Forms\Components\TextInput::make('name')
                                            ->columnSpan(12)
                                            ->required(),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Email')
                                            ->columnSpan(12)
                                            ->required(),
                                        Forms\Components\Select::make('occupation')
                                            ->label('Job Role')
                                            ->relationship('occupation', 'name')
                                            ->required()
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('security')
                            ->label('Security')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Select::make('role')
                                            ->label('Access Roles')
                                            ->required()
                                            ->multiple()
                                            ->relationship('roles','name')
                                            ->preload()
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('password')
                                            ->password()
                                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                            ->same('confirm_password')
                                            ->dehydrated(fn($state) => filled($state))
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('confirm_password')
                                            ->label('Confirm Password')
                                            ->password()
                                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                                            ->dehydrated(false)
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12),
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(7),
                Forms\Components\Card::make()
                    ->hidden(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->schema([
                        Forms\Components\Fieldset::make('discount')
                            ->label('Discount')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Toggle::make('discount_allowed')
                                            ->label('Allowed to add Discounts')
                                            ->inline()
                                            ->columnSpan(12),
                                        Forms\Components\TextInput::make('discount_rate')
                                            ->label('Allowed Maximum Discount')
                                            ->disabled()
                                            ->columnSpan(12),
                                        Forms\Components\Select::make('discount')
                                            ->label('Regions')
                                            ->multiple()
                                            ->options(Region::all()->pluck('name', 'id'))
                                            ->required()
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12),
                            ])
                            ->columnSpan(12),
                    ])
                    ->columnSpan(5),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}
