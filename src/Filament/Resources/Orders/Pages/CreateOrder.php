<?php

namespace Mortezaa97\Orders\Filament\Resources\Orders\Pages;

use Mortezaa97\Orders\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
