import { useState, useEffect, Component } from "react";
import Button from "@/components/Button";
import FormGroup from "@/Components/FormGroup";
import {z} from "zod";
import axios from "axios";

export default function List(){
    const [restaurants, setRestaurant] = useState([]);
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
                    <div className="grid grid-cols-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 gap-4 p-2">
                        {restaurants?.length === 0 ? (
                            <div>
                                Attenzione: nessun ristorante disponibile al momento
                            </div>                            
                        ) : (
                            restaurants.map((restaurant) => (
                                <div className="border border-gray-300 rounded-lg" key={restaurant.id}>
                                    <div className="bg-blue-300 p-2 text-center font-semibold">
                                        {restaurant.name}
                                    </div>
                                    <div className="p-2">
                                        <div>Indirizzo: {restaurant.address}, {restaurant.city}</div>
                                    </div>             
                                    <div className="p-4 text-center">
                                        <Button className="bg-blue-400 text-white p-4 pt-2 pb-2 rounded-4xl w-32 m-auto" text="Vai al menu" onClick={() => alert(`Vai al ristorante ${restaurant.name}`)}/>
                                    </div>
                                </div>                            
                            ))
                        )}
                    </div>                    
                </div>
            </div>
        </div>
    )
}