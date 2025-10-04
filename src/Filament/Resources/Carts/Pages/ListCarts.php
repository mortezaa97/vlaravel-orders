<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\Carts\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Mortezaa97\Orders\Filament\Resources\Carts\CartResource;

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
