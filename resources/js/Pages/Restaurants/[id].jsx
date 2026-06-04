import { useState, useEffect, useContext } from "react";
import axios from "axios";
import { CartContext } from "@/context/CartContext";
import Button from "@/Components/Button";
import Menu from "@/Pages/Restaurants/Menu";

export default function Restaurant(props){
    const {cart, addToCart, getCartTotal} = useContext(CartContext);
    const [menu ,setMenu] = useState([]);
    const placeOrder = () => {
        axios.post('/api/order/place', {cart: cart, restaurant_id: props.id})
        .then((success) => {
            window.location.href=success.data.url;
        })
        .cath((error) => {
            console.log(error);
        })
    }
    useEffect(() => {
        axios.get('/api/restaurants/'+props.id+'/menu')
        .then((res) => {
            setMenu(res.data.menu);
            console.log(res.data);
        });
    }, []);
    return (
        <div>
            <div className="flex justify-center mt-4 gap-2">
                <div className="w-full max-w-4xl border border-gray-300 rounded-lg">
                    <div className="bg-blue-300 p-2 text-center font-semibold">
                        Info del ristorante
                    </div>
                    <div className="p-2">
                        {props.error !== null && (
                            <div key="error">{props.error}</div>
                        )}
                        {props.hasOwnProperty('error')===false && (
                            <div key="menu_heading">
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
                    <Menu menu={menu} />
                </div>
                <div className="w-1/6 max-md border border-gray-300 rounded-lg">
                    <div className="bg-blue-300 p-2 text-center font-semibold">
                        Carrello
                    </div>
                    <div className="p-2">
                        {cart?.length===0 ? (
                            <>
                                Il carrello è vuoto
                            </>
                        ) : (
                            <div className="p-4 flex flex-col gap-4">
                                <div className="divide-y divide-gray-100">
                                    {cart.map((item) => (
                                        <div key={item.id} className="py-3 flex justify-between items-center text-sm">
                                            <div className="flex flex-col">
                                                <span className="font-semibold text-gray-800 capitalize">
                                                    {item.name} (qta {item.quantity})
                                                </span>
                                                <span className="text-xs text-gray-400">
                                                    {Number(item.price).toFixed(2)}€ l'uno
                                                </span>
                                            </div>                                            
                                            <div className="flex flex-col">
                                                {(item.price * item.quantity).toFixed(2)}&euro;
                                            </div>
                                        </div>
                                    ))}
                                </div>
                                <div className="border-t border-gray-300 pt-4 flex justify-between items-center font-bold text-lg mb-4">
                                    <span>Totale:</span>
                                    <span className="text-blue-600">{Number(getCartTotal()).toFixed(2)}€</span>
                                </div>
                                <div className="text-center">
                                    <Button onClick={placeOrder}  className="bg-blue-400 p-4 text-white rounded-lg" text="Ordina" />
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}