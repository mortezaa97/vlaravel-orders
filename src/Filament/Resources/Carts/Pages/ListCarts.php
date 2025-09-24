<?php

namespace Mortezaa97\Orders\Filament\Resources\Carts\Pages;

use Mortezaa97\Orders\Filament\Resources\Carts\CartResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCarts extends ListRecords
{
    protected static string $resource = CartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
