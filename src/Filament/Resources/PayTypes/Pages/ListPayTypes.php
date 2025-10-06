<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\PayTypes\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Mortezaa97\Orders\Filament\Resources\PayTypes\PayTypeResource;

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
