<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DishResource\Pages;
use App\Filament\Resources\DishResource\RelationManagers;
use App\Models\Dish;
use App\Models\DishCategory;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DishResource extends Resource
{
    protected static ?string $model = Dish::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Dishes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('restaurant_id')
                    ->options(function(){
                        $r = Restaurant::all();
                        $rr = [];
                        foreach($r as $r_temp){
                            $rr[$r_temp['id']] = $r_temp['name'];
                        }
                        return $rr;
                    }),
                Select::make('category_id')
                    ->options(function(){
                        $c = DishCategory::all();
                        $cc = [];
                        foreach($c as $c_temp){
                            $cc[$c_temp['id']] = $c_temp['dish_category'];
                        }
                        return $cc;
                    }),
                TextInput::make('name'),
                TextInput::make('description'),
                FileUpload::make('image_url'),
                TextInput::make('price'),
                TextInput::make('discount_price'),
                TextInput::make('vat_rate'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('restaurant_id'),
                TextColumn::make('category_id'),
                TextColumn::make('name'),
                TextColumn::make('description'),
                TextColumn::make('image_url'),
                TextColumn::make('price'),
                TextColumn::make('discount_price'),
                TextColumn::make('vat_rate'),
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
            'index' => Pages\ListDishes::route('/'),
            'create' => Pages\CreateDish::route('/create'),
            'edit' => Pages\EditDish::route('/{record}/edit'),
        ];
    }    
}
