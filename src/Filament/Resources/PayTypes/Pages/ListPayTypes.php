<?php

namespace Mortezaa97\Orders\Filament\Resources\PayTypes\Pages;

use Mortezaa97\Orders\Filament\Resources\PayTypes\PayTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPayTypes extends ListRecords
{
    protected static string $resource = PayTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
