import { Component } from "react";
import Input from "@/Components/Input";
import Label from "@/components/Label";
import Button from "@/components/Button";

class Login extends Component{
    constructor(props){
        super(props);
        this.state = {
            username: "",
            password: ""
        };
    }
    handleChange = (e) => {
        let {name, value} = e.target;
        this.setState({[name]: value}, () => {
            console.log(this.state)
        });
    }
    login = () => {
        console.log("login");
    }
    render(){
        return (
            <div>
                <div className="flex items-center justify-center h-screen">
                    <div className="w-full max-w-sm border border-gray-300 rounded-lg">
                        <div className="bg-blue-300 p-2 text-center font-semibold">
                            Login
                        </div>
                        <div className="pl-4 pr-4 pt-4">
                            <div className="flex items-center gap-4 gap- text-right">
                                <Label className="w-18 text-sm font-medium text-gray-600 shrink-0" htmlFor="" label="Username "/>
                                <Input
                                    type="text"
                                    name="username"
                                    className="flex-1 border border-gray-300 rounded-lg p-2 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                                    placeholder="Inserisci username"
                                    onChange={this.handleChange}    
                                />
                            </div>
                        </div>
                        <div className="pl-4 pr-4 pt-4">
                            <div className="flex items-center gap-4 gap- text-right">
                                <Label className="w-18 text-sm font-medium text-gray-600 shrink-0" htmlFor="" label="Password "/>
                                <Input
                                    type="password"
                                    name="password"
                                    className="flex-1 border border-gray-300 rounded-lg p-2 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                                    placeholder="Inserisci password"
                                    onChange={this.handleChange}    
                                />                            
                            </div>
                        </div>
                        <div className="p-4">
                            <div className="flex items-center gap-4 gap-">
                                <Button className="bg-blue-400 text-white p-4 pt-2 pb-2 rounded-4xl w-32 m-auto" text="Login" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Login;