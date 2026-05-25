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

    public function getMenu($id){
        $r = Restaurant::find($id);
        $dishes = $r->dishes()->get();
        $dish = [];
        $category = [];
        foreach($dishes as $d){
            $dish[$d['id']] = $d;
            if(!array_key_exists($d['category_id'], $category)){
                $category[$d['category_id']] = [
                    'category' => $d['category_id'],
                    'dishes' => []
                ];
            }
            $category[$d['category_id']]['dishes'][] = $d->toArray();            
        }
        return response()->json(array_values($category), 200);
    }
}
