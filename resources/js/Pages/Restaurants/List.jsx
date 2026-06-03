import { useState, useEffect, Component } from "react";
import Button from "@/components/Button";
import FormGroup from "@/Components/FormGroup";
import {z} from "zod";
import axios from "axios";

export default function List(){
    const [restaurants, setRestaurant] = useState([]);
    const redirectRestaurant = (id) => {
        window.location.href = "/restaurants/"+id;
    }
    useEffect(() => {
        axios.get('/api/restaurants/list')
        .then((res) => {
            setRestaurant(res.data.restaurants);
        });  
    }, []);
    return (
        <div>
            <div className="flex justify-center mt-4">
                <div className="w-full max-w-4xl border border-gray-300 rounded-lg">
                    <div className="bg-blue-300 p-2 text-center font-semibold">
                        Lista dei ristoranti
                    </div>
                    <div className="grid grid-cols-2 gap-4 p-2">
                        {restaurants?.length === 0 ? (
                            <div>
                                Attenzione: nessun ristorante disponibile al momento
                            </div>                            
                        ) : (
                            restaurants.map((restaurant) => (
                                <>
                                    <div key={restaurant.id} className="border border-gray-300 p-2 rounded-lg">
                                        <div className="h-48 w-full relative">
                                            <img src={"https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=500&auto=format&fit=crop&q=60"} className="h-full w-full object-cover" />
                                            <span className="absolute top-3 left-3 bg-gray-300 p-2 rounded-4xl text-xs">{restaurant.type}</span>
                                        </div>
                                        <div className="p-5 pb-1">
                                            <span className="font-bold">{restaurant.name}</span>
                                        </div>
                                        <div className="pl-4 pb-3">
                                            📍<span className="font-light">{restaurant.address}</span>
                                        </div>
                                        <div className="">
                                            <Button className="bg-blue-400 text-white w-full p-2 rounded-md" text="vedi menu" onClick={() => redirectRestaurant(restaurant.id)} />
                                        </div>
                                    </div>
                                </>
                            ))                            
                        )}
                    </div>                    
                </div>
            </div>
        </div>
    )
}