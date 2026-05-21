<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    //
    public function list(){
        $r = Restaurant::all();
        return response()->json(['restaurants' => $r], 200);
    }
}
