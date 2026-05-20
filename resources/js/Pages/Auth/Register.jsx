import { useState, useEffect } from "react";
import Button from "@/Components/Button";
import FormGroup from "@/Components/FormGroup";

export default function Register(){
    const [form, setForm] = useState({
        type: ""
    });
    const buildSelect = () => {
        let type = ['utente', 'admin'];
        return type;
    };
    const handleChange = (e) => {
        let {name, value} = e.target;
        setForm((prev) => ({
            ...prev,
            [name]: value
        }));
    };
    useEffect(() => {
        console.log(form);
    }, [form]);
    return (
        <div>
            <div className="flex items-center justify-center h-screen">
                <div className="w-full max-w-4xl border border-gray-300 rounded-lg">
                    <div className="bg-blue-300 p-2 text-center font-semibold">
                        Register {form.type==='admin' && (
                            <span>Admin</span>
                        )}{form.type==='utente' && (
                            <span>Utente</span>
                        )}
                    </div>
                    <div className="grid grid-cols-1 gap-4 p-2">
                        <fieldset className="w-full border border-gray-300 rounded-lg p-4 grid grid-cols-1 md:grid-cols-2">
                            <legend className="pl-1 pr-2">Utenza web</legend>
                            <FormGroup label="type" type="select" name="type" options={buildSelect()} onChange={handleChange}/>
                            <FormGroup label="username" type="input" name="username" onChange={handleChange}/>
                            <FormGroup label="password" type="password" name="password" onChange={handleChange}/>
                        </fieldset>
                        <fieldset className="w-full border border-gray-300 rounded-lg p-4 grid grid-cols-1 md:grid-cols-2">
                            <legend className="pl-1 pr-2">Anagrafica</legend>
                            <FormGroup label="nome" type="input" name="nome" onChange={handleChange}/>
                            <FormGroup label="cognome" type="input" name="cognome" onChange={handleChange}/>                       
                        </fieldset>
                    </div>
                    <div className="p-4">
                        <div className="flex items-center gap-4 gap-">
                            <Button className="bg-blue-400 text-white p-4 pt-2 pb-2 rounded-4xl w-32 m-auto" text="Register" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}