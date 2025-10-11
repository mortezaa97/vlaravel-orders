<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\Orders\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Mortezaa97\Orders\Filament\Resources\Orders\OrderResource;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('چاپ فاکتور')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn () => route('orders.print', $this->record))
                ->openUrlInNewTab(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Update read_at and read_by when the page is opened
        $this->record->update([
            'read_at' => now(),
            'read_by' => Auth::id(),
        ]);
    }
}
