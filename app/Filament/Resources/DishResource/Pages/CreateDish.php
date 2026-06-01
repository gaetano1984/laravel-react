<?php

namespace App\Filament\Resources\DishResource\Pages;

use App\Filament\Resources\DishResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Stripe\StripeClient;
use App\Models\Dish;

class CreateDish extends CreateRecord
{
    protected static string $resource = DishResource::class;

    public function afterCreate(){
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $product = $stripe->products->create([
            'name' => $this->record->name,
            'default_price_data' => [
                'unit_amount' => $this->record->price,
                'currency' => 'eur',
            ],
        ]);

        $dish = Dish::find($this->record->id);
        $dish->stripe_id = $product['id'];
        $dish->save();

        \Log::info(print_r($product, 1));
    }
}
