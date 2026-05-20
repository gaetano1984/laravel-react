import Input from "./Input";
import Label from "./Label";
import Select from "./Select";

function FormGroup({label, type, name, options, onChange}){
    let content = "";
    if(type === "select"){
        content = <Select id="type" name="type" className="flex-1 border border-gray-300 w-100 rounded-lg p-2" options={options} onChange={onChange} />
    }
    if(type === "input"){
        content = <Input type="text" name={name} className="flex-1 border border-gray-300 rounded-lg p-2 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" placeholder={"Inserisci " + label} onChange={onChange} />
    }
    if(type === "password"){
        content = <Input type="password" name={name} className="flex-1 border border-gray-300 rounded-lg p-2 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" placeholder={"Inserisci " + label} onChange={onChange} />
    }
    return (
        <div className="pl-4 pr-4">
            <div className="flex items-center gap-4 gap- text-right">
                <Label className="w-18 text-sm font-medium text-gray-600 shrink-0" htmlFor="" label={label} />
                {content}
            </div>
        </div>
    );
}
export default FormGroup;