<?php

namespace App\Filament\Resources\SolutionResource\RelationManagers;

use App\Models\Project;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $recordTitleAttribute = 'name';

    public function canCreate(): bool
    {
        if ($this->ownerRecord->product->quote != null) {
            return Auth::user()->can('Create Projects In Quotes');
        }
        return Auth::user()->can('Create Projects');
    }

    public function canDelete(Model $record): bool
    {
        if ($this->ownerRecord->product->quote != null) {
            return Auth::user()->can('Delete Projects In Quotes');
        }
        return Auth::user()->can('Delete Projects');
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Project $record): string =>
        ($record->solution->product->quote != null)
            ?
                ($record->solution->product->quote->type == "standard")
                ?
                    url('/admin/projects/'.$record->id.'/edit?type=quote')
                :
                    (($record->solution->product->quote->type == "template")
                        ?
                        url('/admin/projects/'.$record->id.'/edit?type=template')
                        :
                        url('/admin/projects/'.$record->id.'/edit?type=simulation'))
            :
                url('/admin/projects/'.$record->id.'/edit?activeRelationManager=0');
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
                        Forms\Components\Hidden::make('type')
                            ->default(fn(RelationManager $livewire): string => ((!is_null($livewire->ownerRecord->product->quote)) ? (($livewire->ownerRecord->product->quote->type == "standard") ? 'quote' : (($livewire->ownerRecord->product->quote->type == "simulation") ? 'simulation' : 'template')) : 'standard')),
                        Forms\Components\Fieldset::make('basics')
                            ->label('Basics')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(12),
                                        Forms\Components\Toggle::make('status')
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('configuration')
                            ->label('Configuration')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\Select::make('price_category')
                                            ->options([
                                                'standard' => 'Standard',
                                                'branch' => 'Per Branch',
                                                'country' => 'Per Country',
                                            ])
                                            ->columnSpan(6),
                                        Forms\Components\Select::make('personnel_id')
                                            ->label('Assigned Personnel')
                                            ->relationship('personnel', 'title')
                                            ->required()
                                            ->columnSpan(6),
                                    ])
                                    ->columnSpan(12)
                            ])
                            ->columnSpan(12),
                        Forms\Components\Fieldset::make('costing')
                            ->label('Costing')
                            ->schema([
                                Forms\Components\Grid::make(12)
                                    ->schema([
                                        Forms\Components\TextInput::make('hours')
                                            ->required()
                                            ->numeric()
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
                Tables\Columns\BadgeColumn::make('price_category')
                    ->enum([
                        'standard' => 'Standard',
                        'branch' => 'Per Branch',
                        'country' => 'Per Country',
                    ])
                    ->colors([
                        'primary',
                        'secondary' => 'standard',
                        'warning' => 'branch',
                        'success' => 'country',
                    ]),
                Tables\Columns\TextColumn::make('personnel.title')
                    ->label('Assignee'),
                Tables\Columns\TextColumn::make('total_hours')
                    ->label('Hours'),
                Tables\Columns\TextColumn::make('total_cost')
                    ->label('Cost'),
                Tables\Columns\ToggleColumn::make('status'),
            ])
            ->reorderable('order')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->successRedirectUrl(fn (Project $record): string => '/admin/solutions/'.$record->solution->id.'/edit?'.((!is_null($record->solution->product->quote)) ? (($record->solution->product->quote->type == "standard") ? 'type=quote&' : (($record->solution->product->quote->type == "simulation") ? 'type=simulation&' : 'type=template&')) : '').'activeRelationManager=0'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit-product-project')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->product->quote != null) ? true : false)
                    ->url(fn (Project $record): string => url('/admin/projects/'.$record->id.'/edit'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\Action::make('edit-quote-project')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->product->quote != null && $livewire->ownerRecord->product->quote->type == "standard") ? false : true)
                    ->url(fn (Project $record): string => url('/admin/projects/'.$record->id.'/edit?type=quote'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\Action::make('edit-simulation-project')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->product->quote != null && $livewire->ownerRecord->product->quote->type == "simulation") ? false : true)
                    ->url(fn (Project $record): string => url('/admin/projects/'.$record->id.'/edit?type=simulation'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\Action::make('edit-template-project')
                    ->label('Edit')
                    ->hidden(fn (RelationManager $livewire): bool => ($livewire->ownerRecord->product->quote != null && $livewire->ownerRecord->product->quote->type == "template") ? false : true)
                    ->url(fn (Project $record): string => url('/admin/projects/'.$record->id.'/edit?type=template'))
                    ->icon('heroicon-s-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->successRedirectUrl(fn (Project $record): string => '/admin/solutions/'.$record->solution->id.'/edit?'.((!is_null($record->solution->product->quote)) ? (($record->solution->product->quote->type == "standard") ? 'type=quote&' : (($record->solution->product->quote->type == "simulation") ? 'type=simulation&' : 'type=template&')) : '').'activeRelationManager=0'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
