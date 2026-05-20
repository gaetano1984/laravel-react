function Input({type = "text", className, name, placeholder, onChange}){
    return (
        <input type={type} name={name} className={className} placeholder={placeholder} onChange={onChange} />
    );
}

export default Input;