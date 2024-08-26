<?php

namespace App\Filament\Resources\ItemClassResource\Pages;

use App\Filament\Resources\ItemClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemClasses extends ListRecords
{
    protected static string $resource = ItemClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
