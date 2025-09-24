<?php

namespace Mortezaa97\Orders\Filament\Resources\Carts\Schemas;

use Filament\Schemas\Schema;

class CartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \Filament\Forms\Components\TextInput::make('storage_id')->maxLength(255),
                            \App\Filament\Components\Form\StatusSelect::create(),
                            \App\Filament\Components\Form\AddressTextInput::create(),
                            \Filament\Forms\Components\TextInput::make('ip')->maxLength(45),
                            \App\Filament\Components\Form\DescTextarea::create(),
                            \App\Filament\Components\Form\CouponSelect::create(),
                            \App\Filament\Components\Form\CreatedBySelect::create()->required(),
                            \App\Filament\Components\Form\UpdatedBySelect::create(),

                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}
