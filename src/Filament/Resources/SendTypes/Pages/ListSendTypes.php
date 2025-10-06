<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\SendTypes\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Mortezaa97\Orders\Filament\Resources\SendTypes\SendTypeResource;

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
