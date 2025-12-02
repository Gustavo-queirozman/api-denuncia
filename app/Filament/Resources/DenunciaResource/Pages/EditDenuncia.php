<?php

namespace App\Filament\Resources\DenunciaResource\Pages;

use App\Filament\Resources\DenunciaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDenuncia extends EditRecord
{
    protected static string $resource = DenunciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
