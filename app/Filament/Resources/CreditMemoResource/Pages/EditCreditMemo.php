<?php

namespace App\Filament\Resources\CreditMemoResource\Pages;

use App\Filament\Resources\CreditMemoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditMemo extends EditRecord
{
    protected static string $resource = CreditMemoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
