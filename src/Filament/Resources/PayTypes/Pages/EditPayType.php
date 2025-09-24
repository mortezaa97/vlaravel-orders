<?php

namespace Mortezaa97\Orders\Filament\Resources\PayTypes\Pages;

use Mortezaa97\Orders\Filament\Resources\PayTypes\PayTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPayType extends EditRecord
{
    protected static string $resource = PayTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
