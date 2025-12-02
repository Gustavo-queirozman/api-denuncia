<?php

namespace App\Filament\Resources\DenunciaResource\Pages;

use App\Filament\Resources\DenunciaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListDenuncias extends ListRecords
{
    protected static string $resource = DenunciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
