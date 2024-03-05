<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Region;
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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 10;

    protected static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->can('Access Users');
    }

    public static function canViewAny(): bool
    {
        return (Auth::user()->can('Access Users') || Auth::user()->can('Edit Users'));
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create Users');
    }

    public static function canEdit(Model $record): bool
    {
        if (Auth::user()->can('Access Users')) {
            return Auth::user()->can('Edit Users');
        }
        if (Auth::user()->can('Edit Users') && !Auth::user()->can('Access Users')) {
            if (Auth::id() == $record->id) {
                return Auth::user()->can('Edit Users');
            }
        }
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('Delete Users');
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
                                        Forms\Components\Select::make('reportingManager')
                                            ->label('Reporting Manager')
                                            ->disabled()
                                            ->relationship('reportingManager', 'name', fn (Builder $query) => $query->where('type','staff'))
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
                                            ->disabled()
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
                    ->schema([
                        Forms\Components\Fieldset::make('discount')
                            ->label('Discount')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('discount_rate')
                                            ->default(0.00)
                                            ->label('Allowed Maximum Discount')
                                            ->disabled()
                                            ->columnSpan(12),
                                    ])
                                    ->columnSpan(12),
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('settings')
                            ->label('Settings')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Select::make('discount')
                                            ->label('Regions')
                                            ->multiple()
                                            ->disabled()
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
                Tables\Columns\TextColumn::make('type'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
