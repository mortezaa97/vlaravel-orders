<?php

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
                \Filament\Tables\Columns\TextColumn::make('coupon.name')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('delivery_price')->numeric()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('coupon_price')->numeric()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_price')->numeric()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('payment_type')->numeric()->sortable(),
                \App\Filament\Components\Table\PaymentTextColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('tracking_code')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('sendType.title')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('payType.title')->searchable(),
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
