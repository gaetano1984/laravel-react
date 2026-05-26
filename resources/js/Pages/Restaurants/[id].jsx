import { useState, useEffect } from "react";
import axios from "axios";

export default function Restaurant(props){
    const [menu ,setMenu] = useState([]);
    useEffect(() => {
        axios.get('/api/restaurants/'+props.id+'/menu')
        .then((res) => {
            setMenu(res.data.menu);
            console.log(res.data);
        });
    }, []);
    return (
        <div>
            <div className="flex justify-center mt-4">
                <div className="w-full max-w-4xl border border-gray-300 rounded-lg">
                    <div className="bg-blue-300 p-2 text-center font-semibold">
                        Info del ristorante
                    </div>
                    <div className="p-2">
                        {props.error !== null && (
                            <div>{props.error}</div>
                        )}
                        {props.hasOwnProperty('error')===false && (
                            <div>
                                <div className="grid grid-cols-3 gap-4 p-2">
                                    <div className="flex flex-col">
                                        <img className="w-full h-full max-h-90 object-cover rounded-lg" src="/images/img-restaurant.jpeg" />
                                    </div>
                                    
                                    <div className="flex flex-col justify-between col-span-2">
                                        <div className="font-semibold text-lg">
                                            {props.name}
                                        </div>               
                                        <div className="font-extralight pt-3 pb-3">
                                            <span className="bg-emerald-50 text-emerald-700  boder border-black rounded-lg font-medium p-2">
                                                {props.type}
                                            </span>
                                        </div>                             
                                        <div className="text-sm font-light">
                                            {props.address}, {props.city} - {props.CAP}
                                        </div>
                                    </div>
                                </div>
                                <div className="grid grid-cols-1 mt-10 p-2">
                                    <div className="flex flex-col text-center">
                                        Menu
                                    </div>                              
                                </div>
                            </div>                            
                        )}
                        
                    </div>
                    {menu?.length===0 ? (
                        <div>vuoto</div>
                    ) : (
                        menu.map((category) => (
                            <div className="p-5">
                                <fieldset className='border border-gray-300 rounded-lg p-2'>
                                    <legend>Categoria {category.category}</legend>
                                    <div className="grid grid-cols-2 p-2 gap-2">
                                        {category.dishes.map((dish) => (
                                            <div className="w-full max-w-4xl border border-gray-300 rounded-lg">
                                                <div className="bg-blue-300 p-2 text-center font-semibold">
                                                    {dish.name}
                                                </div>
                                                <div className="grid grid-cols-3">
                                                    <div className="p-2">
                                                        {dish.description}
                                                    </div>
                                                    <div className="p-2 text-right">
                                                        {dish.price}&euro;
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>                                    
                                </fieldset>
                            </div>                            
                        ))
                    )}
                </div>
            </div>
        </div>
    );
}