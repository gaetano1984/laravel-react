import React, { createContext, useState } from 'react';

// Creiamo l'interruttore generale che i componenti "ascolteranno"
export const CartContext = createContext();

// Creiamo il contenitore (Provider) che conterrà i dati veri e propri
export const CartProvider = ({ children }) => {
    // Il nostro carrello parte come un array vuoto []
    const [cart, setCart] = useState([]);

    // Funzione per aggiungere un piatto al carrello
    const addToCart = (dish) => {
        console.log("add to cart");
        console.log(dish);
        setCart((prevCart) => {
            // Controlliamo se il piatto è già nel carrello
            const itemExists = prevCart.find(item => item.id === dish.id);

            if (itemExists) {
                // Se c'è già, incrementiamo solo la quantità di 1
                return prevCart.map(item =>
                    item.id === dish.id ? { ...item, quantity: item.quantity + 1 } : item
                );
            }

            // Se è un piatto nuovo, lo aggiungiamo all'array con quantità 1
            return [...prevCart, { ...dish, quantity: 1 }];
        });
    };

    const getCartTotal = () => {
        return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    };

    return (
        // Distribuiamo il carrello e la funzione addToCart a tutta l'app
        <CartContext.Provider value={{ cart, addToCart , getCartTotal}}>
            {children}
        </CartContext.Provider>
    );
};