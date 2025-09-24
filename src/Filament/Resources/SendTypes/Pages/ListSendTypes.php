<?php

namespace Mortezaa97\Orders\Filament\Resources\SendTypes\Pages;

use Mortezaa97\Orders\Filament\Resources\SendTypes\SendTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSendTypes extends ListRecords
{
    protected static string $resource = SendTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
