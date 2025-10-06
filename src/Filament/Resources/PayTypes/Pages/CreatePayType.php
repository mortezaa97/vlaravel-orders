<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\PayTypes\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Orders\Filament\Resources\PayTypes\PayTypeResource;

class CreatePayType extends CreateRecord
{
    protected static string $resource = PayTypeResource::class;
}
