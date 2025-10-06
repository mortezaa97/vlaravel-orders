<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\SendTypes\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Mortezaa97\Orders\Filament\Resources\SendTypes\SendTypeResource;

class EditSendType extends EditRecord
{
    protected static string $resource = SendTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
