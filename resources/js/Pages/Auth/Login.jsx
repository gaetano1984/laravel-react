import { useState, Component } from "react";
import Button from "@/components/Button";
import FormGroup from "@/Components/FormGroup";
import {z} from "zod";
import axios from "axios";

//class Login extends Component{
export default function Login(){
    const [form, setForm] = useState({
        username: "",
        password: "",
        errorUsername: "",
        errorPassword: ""
    });
    const handleChange = (e) => {
        //e.target.className.replace('border-red-300', 'border-grady-300');
        let {name, value} = e.target;
        setForm((prev) => ({
            ...prev,
            [name]: value
        }));
    };
    const login = (e) => {
        try{
            const data = z.object({
                username: z.string().min(1, "Username is required"),
                password: z.string().min(1, "Password is required")
            }).parse(form); 
            axios.post('api/user/login', data)
                .then((success) => {
                    sessionStorage.setItem('token', success.data.token);
                    window.location.href = "/restaurants/list";
                })
                .catch((e) => console.log(e.response.data))
            ;
        }
        catch(e){
            if(e instanceof z.ZodError){
                e.issues.map((err) => {
                    if(err.path[0]==='username'){
                        setForm((prev) => ({
                            ...prev,
                            'errorUsername': err.message
                        }))
                    }
                    
                    if(err.path[0]==='password'){
                        setForm((prev) => ({
                            ...prev,
                            'errorPassword': err.message
                        }))
                    }
                });
            }
        }        
    };
    return (
        <div>
            <div className="flex items-center justify-center h-screen">
                <div className="w-full max-w-sm border border-gray-300 rounded-lg">
                    <div className="bg-blue-300 p-2 text-center font-semibold">
                        Login
                    </div>
                    <div className="grid grid-cols-1 gap-4 p-2">
                        <FormGroup label="username" type="input" name="username" options="" onChange={handleChange} error={form.errorUsername}></FormGroup>
                        <FormGroup label="password" type="password" name="password" options="" onChange={handleChange} error={form.errorPassword}></FormGroup>
                        <div className="p-4">
                            <div className="flex items-center gap-4 gap-">
                                <Button className="bg-blue-400 text-white p-4 pt-2 pb-2 rounded-4xl w-32 m-auto" text="Login" onClick={login}/>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    )
}