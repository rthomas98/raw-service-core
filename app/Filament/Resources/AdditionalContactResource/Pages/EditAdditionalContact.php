<?php

namespace App\Filament\Resources\AdditionalContactResource\Pages;

use App\Filament\Resources\AdditionalContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdditionalContact extends EditRecord
{
    protected static string $resource = AdditionalContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
