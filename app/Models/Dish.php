<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'category_id', 'name', 'description', 'image_url', 'price', 'discount_price', 'vat_rate'];

    public function ingredients(){
        return $this->belongsToMany(Ingredient::class, 'ingredients_dishes', 'dish_id', 'ingredient_id');
    }
}
