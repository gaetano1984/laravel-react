<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'address', 'CAP', 'type'];

    public function dishes(){
        return $this->belongsToMany(Dish::class, 'restaurant_dishes', 'restaurant_id', 'dishes_id');
    }
}
