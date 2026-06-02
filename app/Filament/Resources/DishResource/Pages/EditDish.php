<?php

namespace App\Filament\Resources\DishResource\Pages;

use App\Filament\Resources\DishResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Stripe\StripeClient;
use App\Models\Dish;

class EditDish extends EditRecord
{
    protected static string $resource = DishResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function afterSave(){
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $price = $stripe->prices->create([
            'currency' => 'eur'
            ,'unit_amount' => intval($this->record->price)
            ,'product' => $this->record->stripe_id
        ]);
        $product = $stripe->products->update($this->record->stripe_id, [
            'name' => $this->record->name,
            'default_price' => $price['id']
        ]);
        $this->record->price_id = $price['id'];
        $this->record->save();
    }
}
