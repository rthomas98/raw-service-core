<?php

namespace App\Filament\Resources\ItemClassResource\Pages;

use App\Filament\Resources\ItemClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemClass extends EditRecord
{
    protected static string $resource = ItemClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
