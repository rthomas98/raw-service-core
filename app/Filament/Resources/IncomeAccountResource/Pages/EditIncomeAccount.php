<?php

namespace App\Filament\Resources\IncomeAccountResource\Pages;

use App\Filament\Resources\IncomeAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomeAccount extends EditRecord
{
    protected static string $resource = IncomeAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
