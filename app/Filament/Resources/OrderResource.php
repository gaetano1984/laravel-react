<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use App\Models\Dish;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Card::make([
                    Repeater::make('order')
                    ->schema(function($record){
                        $order = $record->order;
                        $inputs = [];
                        foreach($order as $row_order){
                            $inputs['name'] = TextInput::make('name')->formatStateUsing(function() use($row_order){
                                $dish = Dish::where('price_id', $row_order['price'])->first();
                                return $dish['name'];
                            }); 
                            $inputs['price'] = TextInput::make('price')->formatStateUsing(function() use($row_order){
                                $dish = Dish::where('price_id', $row_order['price'])->first();
                                return $dish['price']."€";
                            });
                            $inputs['quantity'] = TextInput::make('quantity')->formatStateUsing(function() use($row_order){
                                return $row_order['quantity'];
                            });
                        }
                        return $inputs;
                    })
                    ->label('Dettagli ordine')  
                ])
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('user.email')->label('Cliente'),
                TextColumn::make('restaurant.name')->label('Ristorante'),
                TextColumn::make('status')->label('Stato')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
