<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use App\Jobs\SendAssignmentEmail;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\EditRecord;

class EditQuote extends EditRecord
{
    protected ?string $heading = 'Quote';

    protected static string $resource = QuoteResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('assign')
                ->label('Assign')
                ->action(function (array $data): void {
                    $this->record->assignee()->associate(User::findOrFail($data['assignee_id']));
                    $this->record->save();

                    SendAssignmentEmail::dispatch($this->record);
                })
                ->form([
                    Forms\Components\Select::make('assignee_id')
                        ->label('Assignee')
                        ->default($this->record->assignee?->id)
                        ->relationship('assignee', 'name', fn (Builder $query) => $query->where('type','staff'))
                        ->required(),
                ]),
            Actions\DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    public function getFormTabLabel(): ?string
    {
        return 'Quote';
    }
}
