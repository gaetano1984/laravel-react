<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    //
    public function list(){
        $r = Restaurant::all();
        return response()->json(['restaurants' => $r], 200);
    }

    public function info(int $id){
        try{
            $data = Restaurant::findOrFail($id)->toArray();
            return Inertia::render('Restaurants/[id]', $data);
        }
        catch(\Exception $e){
            $data = ['error' => $e->getMessage()];
            return Inertia::render('Restaurants/[id]', $data);
        }
    }
}
