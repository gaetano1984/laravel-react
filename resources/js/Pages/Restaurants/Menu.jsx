import { useState, useEffect, useContext } from "react";
import { CartContext } from "@/context/CartContext";

export default function Menu(props){
    const {cart, addToCart, removeFromCart, getCartTotal} = useContext(CartContext);
    const [activeTab, setActive] = useState('primo');
    return (
        <>
            <div className="max-w-2xl mx-auto mt-5 border border-white rounded-lg">
                <ul className="flex m-0 p-0 list-none">
                    {props.menu.map((category) => {
                        let isActive = activeTab===category.category;
                        return (
                            isActive===true ? 
                                <li key={category.category} className="flex-1">
                                    <button onClick={() => setActive(category.category)} className="w-full padding py-4 text-center font-bold text-base border-b-3 transition-all duration-300 cursor-pointer bg-white text-blue-300 p-2 border border-blue-300">{category.category}</button>
                                </li> : 
                                <li key={category.category} className="flex-1">
                                    <button onClick={() => setActive(category.category)} className="w-full padding py-4 text-center font-bold text-base border-b-3 transition-all duration-300 cursor-pointer bg-blue-300 text-white p-2 border-blue-300">{category.category}</button>
                                </li>
                        )
                    })}
                </ul>
            </div>
            <div className="border border-blue-300 p-4 mx-4 mb-4 mt-0">
                <div className="grid grid-cols-2 gap-2">
                    {props.menu.length>0 ?
                        props.menu.map((cat) => {
                            if(cat.category===activeTab){
                                return cat.dishes.map((dish) => {
                                    return (
                                        <div key={dish.id} className="flex flex-col border border-blue-300 p-2 rounded-lg">
                                            <div className="flex gap-4">
                                                <div className="shrink-0">
                                                    <img className="w-20 h-20 object-cover rounded-lg" src="/images/img-restaurant.jpeg" />
                                                </div>
                                                <div className="flex flex-col flex-1">
                                                    <span className="text-lg font-semibold">{dish.name}</span>
                                                    {dish.name}
                                                    <div className="flex justify-between">
                                                        <span className="font-normal">
                                                            {dish.price}&euro;
                                                        </span>
                                                        <span>
                                                            <button key="add" className="bg-blue-300  rounded-4xl pl-2 pr-2 text-white" onClick={(() => removeFromCart(dish))}>-</button>
                                                            <button key="remove" className="ml-1 bg-blue-300  rounded-4xl pl-2 pr-2 text-white" onClick={(() => addToCart(dish))}>+</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    )
                                })
                            }                        
                        })
                        : 
                            <>Nessun piatto configurato per questo ristorante</>
                    }
                </div>
            </div>
        </>
        
    )
}