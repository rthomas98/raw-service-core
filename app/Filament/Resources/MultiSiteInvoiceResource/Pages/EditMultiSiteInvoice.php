<?php

namespace App\Filament\Resources\MultiSiteInvoiceResource\Pages;

use App\Filament\Resources\MultiSiteInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMultiSiteInvoice extends EditRecord
{
    protected static string $resource = MultiSiteInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
