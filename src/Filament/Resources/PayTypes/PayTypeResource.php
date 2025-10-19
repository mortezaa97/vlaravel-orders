<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\PayTypes;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Orders\Filament\Resources\PayTypes\Pages\CreatePayType;
use Mortezaa97\Orders\Filament\Resources\PayTypes\Pages\EditPayType;
use Mortezaa97\Orders\Filament\Resources\PayTypes\Pages\ListPayTypes;
use Mortezaa97\Orders\Filament\Resources\PayTypes\Schemas\PayTypeForm;
use Mortezaa97\Orders\Filament\Resources\PayTypes\Tables\PayTypesTable;
use Mortezaa97\Orders\Models\PayType;

class PayTypeResource extends Resource
{
    protected static ?string $model = PayType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


    protected static ?string $recordTitleAttribute = 'روش های پرداخت';

    protected static ?string $navigationLabel = 'روش های پرداخت';

    protected static ?string $modelLabel = 'روش پرداخت';

    protected static ?string $pluralModelLabel = 'روش های پرداخت';

    protected static string|null|\UnitEnum $navigationGroup = 'تنظیمات';


    public static function form(Schema $schema): Schema
    {
        return PayTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PayTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPayTypes::route('/'),
            'create' => CreatePayType::route('/create'),
            'edit' => EditPayType::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
