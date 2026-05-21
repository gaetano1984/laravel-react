<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantResource\Pages;
use App\Filament\Resources\RestaurantResource\RelationManagers;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Fieldset::make('Anagrafica')->schema([
                    TextInput::make('name'),
                    TextInput::make('city'),
                    TextInput::make('address'),
                    TextInput::make('CAP'),
                    TextInput::make('type'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->label('Rag. Sociale'),
                TextColumn::make('city')->label('Comune'),
                TextColumn::make('address')->label('Indirizzo'),
                TextColumn::make('CAP'),
                TextColumn::make('type')->label('Tipo'),
            ])
            ->filters([
                //
                Filter::make('filter_restaurant')
                    ->form([
                        TextInput::make('filter_name')->label('Name')
                    ])
                    ->query(function(Builder $query, $data){
                        $query->when($data['filter_name'], function(Builder $query, $data){
                            $query->where('name', 'like', "%$data%");
                        });
                    })
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
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
        ];
    }    
}
