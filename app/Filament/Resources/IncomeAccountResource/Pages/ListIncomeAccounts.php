<?php

namespace App\Filament\Resources\IncomeAccountResource\Pages;

use App\Filament\Resources\IncomeAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomeAccounts extends ListRecords
{
    protected static string $resource = IncomeAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
