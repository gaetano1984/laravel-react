<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Restaurant;

class Order extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'restaurant_id', 'order', 'status'];

    protected $casts = ['order' => 'array'];

    public function user(){
        return $this->hasOne(User::class, 'id' , 'user_id');
    }

    public function restaurant(){
        return $this->hasOne(Restaurant::class, 'id', 'restaurant_id');
    }
}
