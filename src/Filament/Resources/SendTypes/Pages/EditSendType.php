<?php

namespace Mortezaa97\Orders\Filament\Resources\SendTypes\Pages;

use Mortezaa97\Orders\Filament\Resources\SendTypes\SendTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSendType extends EditRecord
{
    protected static string $resource = SendTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
