<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientDish extends Model
{
    use HasFactory;

    protected $fillable = ['dish_id', 'ingredient_id'];
}
