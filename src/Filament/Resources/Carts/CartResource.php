<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\Carts;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Orders\Filament\Resources\Carts\Pages\EditCart;
use Mortezaa97\Orders\Filament\Resources\Carts\Pages\ListCarts;
use Mortezaa97\Orders\Filament\Resources\Carts\Schemas\CartForm;
use Mortezaa97\Orders\Filament\Resources\Carts\Tables\CartsTable;
use Mortezaa97\Orders\Models\Cart;
use UnitEnum;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'createdBy.last_name';

    protected static ?string $navigationLabel = 'سبدهای خرید';

    protected static ?string $modelLabel = 'سبد خرید';

    protected static ?string $pluralModelLabel = 'سبدهای خرید';

    protected static string|null|UnitEnum $navigationGroup = 'فروشگاه';

    public static function form(Schema $schema): Schema
    {
        return CartForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CartsTable::configure($table);
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
            'index' => ListCarts::route('/'),
            'edit' => EditCart::route('/{record}/edit'),
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
