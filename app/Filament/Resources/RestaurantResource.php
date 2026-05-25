<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantResource\Pages;
use App\Filament\Resources\RestaurantResource\RelationManagers;
use App\Models\DishCategory;
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
use Filament\Forms\Components\Select;
use App\Models\Dish;

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
                    TextInput::make('name')->label('Rag. Sociale'),
                    TextInput::make('city')->label('Comune'),
                    TextInput::make('address')->label('indirizzo'),
                    TextInput::make('CAP')->label('CAP'),
                    Select::make('type')->options(function(){
                        return [
                            'pizzeria' => 'pizzeria'
                            ,'trattoria' => 'trattoria'
                            ,'osteria' => 'osteria'
                            ,'ristorante' => 'ristorante'
                        ];
                    })
                ]),
                
                Forms\Components\Fieldset::make('Menu')->schema(function() {
                    $categories = DishCategory::all();
                    $list = [];
                    
                    foreach($categories as $category){
                        $list[] = Forms\Components\Fieldset::make($category->dish_category)
                            ->schema(function() use ($category) {
                                
                                // 1. Recuperiamo solo i piatti di questa specifica categoria
                                $options = Dish::where('category_id', $category->id)
                                    ->pluck('name', 'id')
                                    ->toArray();

                                return [
                                    Forms\Components\Select::make("category_dishes_{$category->id}")
                                        ->label('Seleziona i piatti')
                                        ->options($options)
                                        ->multiple()
                                        ->preload()
                                        
                                        // ISOLAMENTO: Impedisce a Filament di fare confusione tra i campi al salvataggio
                                        ->statePath("menu_categoria_{$category->id}") 
                                        
                                        // STEP 6 & REFRESH: Come caricare i dati corretti dal DB per QUESTA select
                                        ->loadStateFromRelationshipsUsing(function (Forms\Components\Select $component, $record) use ($category) {
                                            if (! $record) return;
                                            
                                            // Estraiamo solo i piatti del ristorante che appartengono a questa categoria
                                            $associatedIds = $record->dishes()
                                                ->where('category_id', $category->id)
                                                ->pluck('dishes.id') // Assicurati che 'dishes.id' sia la PK corretta dei piatti
                                                ->toArray();
                                                
                                            $component->state($associatedIds);
                                        })
                                        
                                        // STEP 3 & 5: Come salvare i dati nel DB senza sovrascrivere le altre categorie
                                        ->saveRelationshipsUsing(function (Forms\Components\Select $component, $record) use ($category) {
                                            if (! $record) return;
                                            
                                            $state = $component->getState() ?? [];
                                            
                                            // 1. Prendiamo tutti i piatti attualmente associati al ristorante
                                            $currentDishes = $record->dishes()->pluck('dishes.id')->toArray();
                                            
                                            // 2. Identifichiamo i piatti di QUESTA categoria che l'utente ha DESELEZIONATO
                                            $dishesInThisCategory = Dish::where('category_id', $category->id)->pluck('id')->toArray();
                                            $dishesToRemove = array_diff($dishesInThisCategory, $state);
                                            
                                            // 3. Calcoliamo il nuovo array globale di piatti da salvare per il ristorante
                                            $newDishes = array_diff($currentDishes, $dishesToRemove); // Rimuoviamo quelli tolti
                                            $newDishes = array_unique(array_merge($newDishes, $state)); // Aggiungiamo quelli nuovi
                                            
                                            // 4. Sincronizziamo la tabella M:N restaurant_dishes
                                            $record->dishes()->sync($newDishes);
                                        }),
                                ];
                            });
                    }
                    return $list;
                })
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
