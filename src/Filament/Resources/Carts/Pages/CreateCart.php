<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\Carts\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Orders\Filament\Resources\Carts\CartResource;

class CreateCart extends CreateRecord
{
    protected static string $resource = CartResource::class;
}
