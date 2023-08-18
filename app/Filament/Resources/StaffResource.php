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
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                Forms\Components\Hidden::make('type')
                    ->default('staff'),
                Forms\Components\TextInput::make('name')
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\Select::make('discount')
                    ->multiple()
                    ->options(Region::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('role')
                    ->required()
                    ->multiple()
                    ->relationship('roles','name')
                    ->preload(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->same('confirm_password')
                    ->dehydrated(fn($state) => filled($state)),
                Forms\Components\TextInput::make('confirm_password')
                    ->label('Confirm Password')
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->dehydrated(false),
            ]);
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
