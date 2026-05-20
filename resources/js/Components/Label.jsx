function Label({className, htmlFor, label}){
    return (
        <label className={className} htmlFor={htmlFor}>{label}</label>   
    );
}

export default Label;