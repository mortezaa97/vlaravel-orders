<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\Orders\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Orders\Filament\Resources\Orders\OrderResource;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
