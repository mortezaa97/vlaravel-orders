<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \App\Filament\Components\Table\CodeTextColumn::create(),
                \App\Filament\Components\Table\UserTextColumn::create(),
                \App\Filament\Components\Table\AddressTextColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('coupon.name')->searchable()
                    ->label('کد تخفیف'),
                \Filament\Tables\Columns\TextColumn::make('delivery_price')->numeric()->sortable()
                    ->label('هزینه ارسال'),
                \Filament\Tables\Columns\TextColumn::make('coupon_price')->numeric()->sortable()
                    ->label('هزینه تخفیف'),
                \Filament\Tables\Columns\TextColumn::make('total_price')->numeric()->sortable()
                    ->label('مجموع قیمت'),
                \Filament\Tables\Columns\TextColumn::make('payment_type')->numeric()->sortable()
                    ->label('نوع پرداخت'),
                \App\Filament\Components\Table\PaymentTextColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('tracking_code')->searchable()
                    ->label('کد پیگیری'),
                \Filament\Tables\Columns\TextColumn::make('sendType.title')->searchable()
                    ->label('نوع ارسال'),
                \App\Filament\Components\Table\CreatedByTextColumn::create(),
                \App\Filament\Components\Table\UpdatedByTextColumn::create(),
                \App\Filament\Components\Table\DeletedAtTextColumn::create(),
                \App\Filament\Components\Table\CreatedAtTextColumn::create(),
                \App\Filament\Components\Table\UpdatedAtTextColumn::create(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
