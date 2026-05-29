<?php

namespace App\Http\Controllers;

use App\Models\DishCategory;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use Inertia\Inertia;
use Stripe\StripeClient;

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

    public function getMenu(int $id){
        $dish = [];
        $r = Restaurant::findOrFail($id);
        $menu = $r->dishes()->get()->toArray();
        foreach($menu as $m){
            if(!array_key_exists($m['category_id'], $dish)){
                $dish[$m['category_id']] = [
                    'id' => $m['category_id']
                    ,'category' => DishCategory::find($m['category_id'])->dish_category
                    ,'dishes' => []
                ];
            }
            array_push($dish[$m['category_id']]['dishes'], $m);
        }
        return response()->json(['menu' => array_values($dish)], 200);
    }

    public function placeOrder(Request $request){
        $secret = env('STRIPE_SECRET');
        $client = new StripeClient($secret);

        $line_items = array_map(function($a){
            return [
                'price' => $a['price_id']
                ,'quantity' => $a['quantity']
            ];
        }, $request->all());

        $session = $client->checkout->sessions->create([
            'success_url' => 'https://google.it',
            'line_items' => $line_items,
            'mode' => 'payment'
        ]);
        return response()->json(['url' => $session->url], 200);
    }
}
