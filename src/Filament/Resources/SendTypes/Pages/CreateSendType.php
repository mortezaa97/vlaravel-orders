<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\SendTypes\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Orders\Filament\Resources\SendTypes\SendTypeResource;

class CreateSendType extends CreateRecord
{
    protected static string $resource = SendTypeResource::class;
}
