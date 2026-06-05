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
use Filament\Forms\Components\PLaceholder;
use Filament\Forms\Components\Fieldset;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Fieldset::make('dettagli ordine')->schema([
                    Card::make([
                        Placeholder::make('order')
                        //->label('dettagli carrello')
                        ->content(function($record){
                            $order = json_decode($record->order, TRUE);
                            $totale = 0;
                            $table = array_map(function($a) use (&$totale){
                                $dish = Dish::where('price_id', $a['price'])->first();
                                $totale += $dish['price']*$a['quantity'];
                                return "<li>".$dish['name']." -  ".$a['quantity']." x ".$dish['price']."€</li>";
                            }, $order);
                            $table = "<ul>".implode("", $table)."</ul>";
                            $table .= "Totale: ".$totale."€";   
                            return new HtmlString($table);
                        })                        
                    ])
                    
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('user.email')->label('Cliente')->formatStateUsing(function($record){
                    $u = User::find($record['user_id'])->first();
                    return $u->name." ".$u->last_name;
                }),
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
