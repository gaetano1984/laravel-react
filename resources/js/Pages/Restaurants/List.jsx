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
                    <div className="grid grid-cols-2 gap-4 p-2">
                        {restaurants?.length === 0 ? (
                            <div>
                                Attenzione: nessun ristorante disponibile al momento
                            </div>                            
                        ) : (
                            restaurants.map((restaurant) => (
                                <div className="bg-white border border-gray-300 rounded-lg p-2">
                                    <div className="flex h-full items-stretch">
                                        <div className="w-1/2 shrink-0">
                                            <img className="w-full h-full max-h-45 object-cover rounded-lg" src="/images/img-restaurant.jpeg" />
                                        </div>
                                        <div className="flex-1 p-2 flex flex-col justify-between pl-5">
                                            <div className="font-semibold text-lg">
                                                {restaurant.name}
                                            </div>               
                                            <div className="font-extralight pt-3 pb-3">
                                                <span className="bg-emerald-50 text-emerald-700  boder border-black rounded-lg font-medium p-2">
                                                    {restaurant.type}
                                                </span>
                                            </div>                             
                                            <div className="text-sm font-light">
                                                {restaurant.address}, {restaurant.city} - {restaurant.CAP}
                                            </div>
                                            <div className="center mt-0">
                                                <Button className="bg-blue-400 text-white p-2 rounded-4xl w-32 mt-4" text="Prenota" onClick={() => alert("Funzionalità in sviluppo")} />
                                            </div>
                                        </div>
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