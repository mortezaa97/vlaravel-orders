<?php

namespace Mortezaa97\Orders\Filament\Resources\SendTypes;

use Mortezaa97\Orders\Filament\Resources\SendTypes\Pages\CreateSendType;
use Mortezaa97\Orders\Filament\Resources\SendTypes\Pages\EditSendType;
use Mortezaa97\Orders\Filament\Resources\SendTypes\Pages\ListSendTypes;
use Mortezaa97\Orders\Filament\Resources\SendTypes\Schemas\SendTypeForm;
use Mortezaa97\Orders\Filament\Resources\SendTypes\Tables\SendTypesTable;
use Mortezaa97\Orders\Models\SendType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SendTypeResource extends Resource
{
    protected static ?string $model = SendType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'SendType';

    public static function form(Schema $schema): Schema
    {
        return SendTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SendTypesTable::configure($table);
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
            'index' => ListSendTypes::route('/'),
            'create' => CreateSendType::route('/create'),
            'edit' => EditSendType::route('/{record}/edit'),
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
